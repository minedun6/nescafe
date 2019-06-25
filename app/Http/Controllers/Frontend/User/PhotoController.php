<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Photo;
use App\Models\PhotoCategory;
use App\Models\Visit;
use Illuminate\Http\Request;
use App\Models\Photoset;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    public function create($type, $id)
    {
        $visit = Visit::find($id);
        $network_type_id = $visit->network->type->id;
        $categories = PhotoCategory::where('visit_type', $type)
            ->where('network_type_id', $network_type_id)
            ->get();

        return view('frontend.' . $type . '.add', array(
            'visit' => $visit,
            'categories' => $categories
        ));
    }

    public function store(Request $request, $type, $id)
    {
        DB::beginTransaction();
        $visit = Visit::find($id);
        $categories_number = count($request->category_id);
        for ($i = 0; $i < $categories_number; $i++) {
            $category = PhotoCategory::find($request->category_id[$i]);
            $field_name = $category->code . 'vitrine';
            $fields = $request->$field_name;
            $photos_number = count($fields);
            $pic_name = $category->code . 'commentaire';
            $descriptions = $request->$pic_name;
            for ($j = 0; $j < $photos_number; $j++) {
                $uploaded_photo = $fields[$j];
                if ($uploaded_photo != null) {
                    if (!substr($uploaded_photo->getMimeType(), 0, 5) == 'image') {
                        return redirect()->back()->withErrors(array(
                            'error' => 'type de photo non pris en charge'
                        ));
                    }
                    $photo_set = Photoset::where('visit_id', $visit->id)
                        ->where('category', $type)
                        ->where('photo_category_id', $category->id)->first();
                    if (!$photo_set) {
                        $photo_set = new Photoset();
                        $photo_set->category = $type;
                        $photo_set->visit_id = $visit->id;
                        $photo_set->photo_category_id = $category->id;
                        $photo_set->save();
                    }

                    $date = \Carbon\Carbon::now();
                    $timestamp = $date->timestamp;
                    $picture = new Photo();
                    $picture->type = $type;
                    $picture->path = $type . '/' . $timestamp . $uploaded_photo->getClientOriginalName();
                    $picture->photo_set_id = $photo_set->id;

                    $picture->description = $descriptions[$j] ? nl2br($descriptions[$j]) : null;
                    $picture->save();
                    $img = Image::make($uploaded_photo->getRealPath());
                    $img->save(public_path('photos/' . $picture->path));
                    $img->save();
                }
            }
        }
        switch ($type) {
            case 'daily':
                $visit->is_answered = true;
                break;
            case 'branding':
                $visit->is_answered_branding = true;
                break;
            case 'display':
                $visit->is_answered_display = true;
                break;
            case 'online':
                $visit->is_answered_online = true;
                break;
            default:
                break;
        }

        $visit->save();
        DB::commit();

        return redirect('visits/' . $type . '/' . $visit->id);
    }


}
