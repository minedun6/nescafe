<?php

namespace App\Http\Controllers\API\v2;

use App\Models\PhotoCategory;
use App\Models\Visit;
use App\Services\Access\Facades\Access;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use App\Models\Photoset;
use App\Models\Photo;
use Illuminate\Support\Facades\Response;

class PhotoAPIController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function getPhoto($id) {
        $id = (int) $id;
        $photo = Photo::find($id);
        if($photo == null){
            Log::notice('[API v2] Error in photo request, invalid id ' . $id . ' sent from : '. Access::user()->name);
            abort(406, 'Invalid photo id');
        }
        $file = File::get(public_path($photo->path));

        $response = Response::make(
            $file,
            200
        );

        $response->header(
            'Content-type',
            File::mimeType(public_path($photo->path))
        );
        return $response;
    }


    public function addPhoto(Request $request)
    {
        $answers = $request->json()->all();
        $visit = Visit::find($answers['visit_id']);
        $category = PhotoCategory::where('code', $answers['category_code'])->first();
        $photo_date = Carbon::createFromTimestamp($answers['timestamp']);

        if (array_key_exists('description', $answers)){
            $description = $answers['description'];
        }
        else {
            $description = null;
        }

        $visit_type = $category->visit_type;
        switch ($visit_type) {
            case 'branding': $is_answered = $visit->is_answered_branding; break;
            case 'display': $is_answered = $visit->is_answered_display; break;
            case 'online': $is_answered = $visit->is_answered_online; break;
            default: $is_answered = true; break;
        }

        if ($visit != null && $category != null && !$is_answered) {

            DB::beginTransaction();
            $photoset = Photoset::where('visit_id', $visit->id)
                ->where('photo_category_id', $category->id)->first();
            if ($photoset == null) {
                $photoset = new Photoset();
                $photoset->category = $visit_type;
                $photoset->visit_id = $visit->id;
                $photoset->photo_category_id = $category->id;
                $photoset->save();
            }

            $photo = Photo::where('photo_date', $photo_date)
                ->where('photo_set_id', $photoset->id)->first();
            if ($photo != null)
                return response()->json(['response' => 'existe']);

            $base64_str = $answers['photo'];

            //decode base64 string
            $image = base64_decode($base64_str);
            $date = \Carbon\Carbon::now();
            $timestamp = $date->timestamp;

            $picture = new Photo();
            $picture->type = $visit_type;
            $picture->photo_set_id = $photoset->id;
            $picture->photo_date = $photo_date;
            $picture->description = $description;
            $picture->save();


            $picture->path = $visit_type . '/' . $timestamp . '.' . $picture->id . '.' . $visit->id . '.jpg';
            $img = Image::make($image);
            $img->save(public_path('photos/' . $picture->path));

            $picture->save();

            DB::commit();
            return response()->json(['response' => 'ok']);
        }
        return response()->json(['response' => 'answered']);
    }

    public function verifyPhotos(Request $request)
    {
        $vars = $request->json()->all();
        $number_var = $vars['count'];
        $visit_id = $vars['visit_id'];
        $visit_type = $vars['visit_type'];
        $visit = Visit::find($visit_id);

        if ($visit == null)
            abort(406, 'Undefined Visit');

        $photosets = Photoset::where('visit_id', $visit_id)
            ->where('category', $visit_type)->get();
        $total = 0;
        foreach ($photosets as $photoset) {
            $total += $photoset->photos()->count();
        }

        if ($total == $number_var) {
            DB::beginTransaction();

            switch ($visit_type) {
                case 'branding': $visit->is_answered_branding = true; break;
                case 'display': $visit->is_answered_display = true; break;
                case 'online':  $visit->is_answered_online = true; break;
                default: break;
            }
            $visit->save();
            DB::commit();
            Log::info('[API v2] Photos added for visit ' . $visit->id . ' sent from : '. Access::user()->name);
            return response()->json(['response' => 'ok']);
        }
        Log::notice('[API v2] Error in ' . $visit->id . ', incorrect number ' . $number_var . ', expected ' . $total . ' sent from : '. Access::user()->name);
        return response()->json(['response' => 'ok']);
        //abort(406, 'Incorrect number, expected ' . $total);
    }
}
