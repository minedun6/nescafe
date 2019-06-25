<?php

namespace App\Http\Controllers\API;

use App\Models\Visit;
use App\Services\Access\Facades\Access;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use App\Models\Photoset;
use App\Models\Photo;

class VisitAPIController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function getVisitsByUser()
    {
        $user = Auth::user();
        $visits = Visit::where('user_id', $user->id)
            ->where('visit_date', '>', \Carbon\Carbon::yesterday())
            ->where('visit_date', '<=', \Carbon\Carbon::now()->addWeek())
        //    ->where('is_answered', false)
            ->get();
        $results = [];
        foreach ($visits as $visit) {
            $results[] = array(
                'type' => $visit->type,
                'visit_date' => $visit->visit_date->format('d/m/Y'),
                'network' => $visit->network ? $visit->network->code : null,
                'check_list' => $visit->checklist ? $visit->checklist->code : null,
            );
        }

        Log::info('[API] All Visits list sent to : '. Access::user()->name);

        return  response()->json($results);
    }

    public function getVisitsByUserByDate(Request $request)
    {

        Log::info('[API] Visits list ' . $request->get('date') . ' sent to : '. Access::user()->name);
        $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        $date->hour = 0;
        $date->minute = 0;
        $date->second = 0;
        $user = Access::user();

        $visits = Visit::where('user_id', $user->id)
            ->where('visit_date', $date)
        //    ->where('is_answered', false)
            ->get();
        /*$results = [];
        foreach ($visits as $visit) {
            $results[] = array(
                'type' => $visit->type,
                'visit_date' => $visit->visit_date->format('Y-m-d'),
                'network' => $visit->network ? $visit->network->code : null,
                'check_list' => $visit->checklist ? $visit->checklist->code : null,
            );
        }*/

        return  $visits;
    }

    public function addAnswer(Request $request){
        //$user = Access::user();
        $answers = $request->json()->all();
        $visit = Visit::find($answers[0]['visit_id']);
        if (!$visit->is_answered) {
            $i = 0;
            $ok = 0;
            $ko = 0;
            foreach ($answers as $a) {
                $answer = new Answer();
                $answer->visit_id = $visit->id;
                $answer->task_id = $a['task_id'];
                $answer->value = $a['value'];
                if ($a['value'] == 'ok') {
                    $ok++;
                } else if ($a['value'] == 'ko') {
                    $ko++;
                }
                $i++;
                $answer->save();
            }

            $ko_percent = ($ko / $i) * 100;
            $ok_percent = ($ok / $i) * 100;
            $visit->anomalies = $ko_percent;
            $visit->bmerch = $ok_percent;

            $visit->is_answered = true;
            $visit->save();
        }

        Log::info('[API] Answer added for visit ' . $visit->id . ' sent from : '. Access::user()->name);
        return response()->json(['response' => 'ok']);
    }

    public function addAnswerWithPhotos(Request $request){
        //$user = Access::user();
        DB::beginTransaction();
        $answers = $request->json()->all();
        $visit = Visit::find($answers[0]['visit_id']);
        if (!$visit->is_answered) {
            if (!$visit->photoSet) {
                $photo_set = new Photoset();
                $photo_set->category = 'daily';
                $photo_set->visit_id = $visit->id;
                $photo_set->save();
                $photoset = $photo_set->id;
            }
            else {
                $photoset = $visit->photoSet->id;
            }

            $i = 0;
            $ok = 0;
            $ko = 0;
            foreach ($answers as $a) {
                $answer = new Answer();
                $answer->visit_id = $visit->id;
                $answer->task_id = $a['task_id'];
                $answer->value = $a['value'];
                if ($a['value'] == 'ok') {
                    $ok++;
                } else if ($a['value'] == 'ko') {
                    $ko++;
                }
                $i++;
                $answer->save();
                if ($a['photo'] != null && $a['photo'] != 'null' && $a['photo'] != '') {
                    //$base64_str = substr($a['photo'], strpos($a['photo'], ",") + 1);
                    $base64_str = $a['photo'];

                    //decode base64 string
                    $image = base64_decode($base64_str);
                    $date = \Carbon\Carbon::now();
                    $timestamp = $date->timestamp;

                    $uploaded_photo = $request->photo;
                    $picture = new Photo();
                    $picture->type = 'task';
                    $picture->path = $timestamp . $visit->id . $answer->id .'.png';
                    $picture->photo_set_id = $photoset;
                    $picture->save();
                    $answer->photo_id = $picture->id;
                    $answer->save();

                    $img = Image::make($image);
                    $img->save(public_path('photos/' . $picture->path));
                }
            }
            $ko_percent = ($ko / $i) * 100;
            $ok_percent = ($ok / $i) * 100;
            $visit->anomalies = $ko_percent;
            $visit->bmerch = $ok_percent;
            $visit->is_answered = true;
            $visit->save();
        }
        DB::commit();
        Log::info('[API] Answer added for visit ' . $visit->id . ' sent from : '. Access::user()->name);
        return response()->json(['response' => 'ok']);
    }

    public function addPhoto(Request $request){
        $date = \Carbon\Carbon::now();
        $timestamp = $date->timestamp;
        //dd($request->all());
        $uploaded_photo = $request->file('photo');
        /*$picture = new Photo();
        $picture->type = 'task';
        $picture->path = $timestamp . $uploaded_photo->getClientOriginalName();
        $picture->save(); */
        $img = Image::make($uploaded_photo->getRealPath());
        $img->save(public_path('photos/' . $timestamp . $uploaded_photo->getClientOriginalName()));

        return response()->json(['response' => 'ok']);
    }

    public function addPhotoJson(Request $request){
        $answers = $request->json()->all();
        $base64_str = substr($answers['photo'], strpos($answers['photo'], ",")+1);;

        //decode base64 string
        $image = base64_decode($base64_str);
        $date = \Carbon\Carbon::now();
        $timestamp = $date->timestamp;

        $uploaded_photo = $request->photo;
        /*$picture = new Photo();
        $picture->type = 'task';
        $picture->path = $timestamp . $uploaded_photo->getClientOriginalName();
        $picture->save(); */
        $img = Image::make($image);
        $img->save(public_path('photos/' . $timestamp . '.jpg'));

        return response()->json(['response' => 'ok']);
    }
}
