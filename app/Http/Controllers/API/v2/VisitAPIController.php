<?php

namespace App\Http\Controllers\API\v2;

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
use App\Models\Photoset;
use App\Models\Photo;
use App\Models\Alerte;

class VisitAPIController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function getVisitsByUserByDate(Request $request)
    {

        Log::info('[API v2] Visits list ' . $request->get('date') . ' sent to : ' . Access::user()->name);
        $date = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        $date->hour = 0;
        $date->minute = 0;
        $date->second = 0;
        $user = Access::user();

        $visits = Visit::where('user_id', $user->id)
            ->where('visit_date', $date)
            ->get();

        return $visits;
    }

    public function addVisitComment(Request $request)
    {
        DB::beginTransaction();
        $data = $request->json()->all();
        $visit = Visit::find($data['visit_id']);
        $comment = $data['comment'];

        $visit->comment = $comment;
        $visit->save();
        DB::commit();

        Log::info('[API v2] Comment added for visit ' . $visit->id . ' sent from : '. Access::user()->name);
        return response()->json(['response' => 'ok']);
    }

    public function addAnswer(Request $request)
    {
        DB::beginTransaction();
        $answers = $request->json()->all();
        $visit = Visit::find($answers['visit_id']);
        $answer_db = Answer::where('visit_id', $answers['visit_id'])
            ->where('task_id', $answers['task_id'])->first();
        if ($visit != null && $answer_db == null && !$visit->is_answered) {
            $daily_photoset = Photoset::where('visit_id', $visit->id)
                ->where('category', 'daily')->first();
            if (!$daily_photoset) {
                $photo_set = new Photoset();
                $photo_set->category = 'daily';
                $photo_set->visit_id = $visit->id;
                $photo_set->save();
                $photoset = $photo_set->id;
            } else {
                $photoset = $daily_photoset->id;
            }

            $answer = new Answer();
            $answer->visit_id = $visit->id;
            $answer->task_id = $answers['task_id'];
            $answer->value = $answers['value'];
            if (array_key_exists('comment', $answers)){
                $answer->comment = $answers['comment'];
            }
            $answer->save();

            if ($answers['photo'] != null && $answers['photo'] != 'null' && $answers['photo'] != '') {
                $base64_str = $answers['photo'];

                //decode base64 string
                $image = base64_decode($base64_str);
                $date = \Carbon\Carbon::now();
                $timestamp = $date->timestamp;


                $picture = new Photo();
                $picture->type = 'task';
                $picture->path = 'daily/' . $timestamp . $visit->id . $answer->id . '.png';

                $img = Image::make($image);
                $img->save(public_path('photos/' . $picture->path));

                $picture->photo_set_id = $photoset;
                $picture->save();
                $answer->photo_id = $picture->id;
                $answer->save();

            }
        }

        DB::commit();
        return response()->json(['response' => 'ok']);
    }

    public function verifyAnswer(Request $request)
    {
        $vars = $request->json()->all();
        $number_var = $vars['count'];
        $visit_id = $vars['visit_id'];
        $visit = Visit::find($visit_id);

        if ($visit == null) {
            Log::notice('[API v2] Error: Invalid visit : '. Access::user()->name);
            abort(406, 'Invalid visit');
        }

        $answers_ok = Answer::where('visit_id', $visit_id)
            ->where('value', 'ok')->count();
        $answers_ko = Answer::where('visit_id', $visit_id)
            ->where('value', 'ko')->count();
        $answers_na = Answer::where('visit_id', $visit_id)
            ->where('value', 'na')->count();

        $total = $answers_ok + $answers_ko + $answers_na;

        if ($total == $number_var) {
            DB::beginTransaction();
            $diviseur = $answers_ok + $answers_ko;
            $ko_percent = 0;
            $ok_percent = 0;
            if ($diviseur != 0) {
                $ko_percent = ($answers_ko / $diviseur) * 100;
                $ok_percent = ($answers_ok / $diviseur) * 100;
                $visit->anomalies = $ko_percent;
                $visit->bmerch = $ok_percent;
            }
            $visit->is_answered = true;
            $visit->save();
            if ($visit->network && ($visit->network->type->code == 'franchise' || $visit->network->type->code == 'boutique'
                    || $visit->network->type->code == 'smart')) {
                if ($ko_percent > 20) {
                    $alerte = new Alerte();
                    $message = "Taux d'anomalie élevé dans ";
                    $message .= ' la ' . $visit->network->type->value . ' ' . $visit->network->name;
                    $alerte->message = $message;
                    $alerte->target_type = 'visit';
                    $alerte->target_id = $visit->id;
                    $alerte->seen = false;
                    $alerte->save();
                }
            } else if ($visit->network && $visit->network->type->code == 'pdvc') {
                if ($ko_percent > 40) {
                    $alerte = new Alerte();
                    $message = "Taux d'anomalie élevé dans ";
                    $message .= ' le ' . $visit->network->type->value . ' ' . $visit->network->name;
                    $alerte->message = $message;
                    $alerte->target_type = 'visit';
                    $alerte->target_id = $visit->id;
                    $alerte->seen = false;
                    $alerte->save();
                }
            } else if ($visit->network && $visit->network->type->code == 'pdvl') {
                if ($ko_percent > 30) {
                    $alerte = new Alerte();
                    $message = "Taux d'anomalie élevé dans ";
                    $message .= ' le ' . $visit->network->type->value . ' ' . $visit->network->name;
                    $alerte->message = $message;
                    $alerte->target_type = 'visit';
                    $alerte->target_id = $visit->id;
                    $alerte->seen = false;
                    $alerte->save();
                }
            }
            DB::commit();
            Log::info('[API v2] Answer added for visit ' . $visit->id . ' sent from : '. Access::user()->name);
            return response()->json(['response' => 'ok']);
        }
        Log::notice('[API v2] Error in ' . $visit->id . ', incorrect number ' . $number_var . ', expected ' . $total . ' sent from : '. Access::user()->name);
        abort(406, 'Incorrect number, expected ' . $total);
    }

    public function addAnswerWithPhotos(Request $request)
    {
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
            } else {
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
                    $picture->path = 'daily/' . $timestamp . $visit->id . $answer->id . '.png';
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
        //Log::info('[API] Answer added for visit ' . $visit->id . ' sent from : '. Access::user()->name);
        return response()->json(['response' => 'ok']);
    }

    public function addPhoto(Request $request)
    {
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

    public function addPhotoJson(Request $request)
    {
        $answers = $request->json()->all();
        $base64_str = substr($answers['photo'], strpos($answers['photo'], ",") + 1);;

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
