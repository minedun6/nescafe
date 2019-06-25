<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Answer;
use App\Models\Photo;
use App\Models\Photoset;
use App\Models\Setting;
use App\Models\Task;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Alerte;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use App\Services\Access\Facades\Access;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function index($type)
    {

    }

    public function create($id)
    {
        $visit = Visit::find($id);
        if ($visit->is_answered)
            return redirect('visits/daily/' . $visit->id);

        return view('frontend.daily.add', array(
            'visit' => $visit
        ));
    }

    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        $visit = Visit::find($id);
        if (!$visit->is_answered) {
            $photo_set = new Photoset();
            $photo_set->category = 'daily';
            $photo_set->visit_id = $id;
            $photo_set->save();

            $answers_number = count($request->task_id);
            $ok = 0;
            $ko = 0;
            for ($i = 0; $i < $answers_number; $i++) {
                $answer = new Answer();
                $answer->visit_id = $visit->id;
                $answer->task_id = $request->task_id[$i];
                $answer->value = $request->radio[$i];
                $answer->comment = $request->remark[$i];
                if ($request->radio[$i] == 'ok') {
                    $ok++;
                } else if ($request->radio[$i] == 'ko') {
                    $ko++;
                    $task = Task::find($request->task_id[$i]);
                    if ($task->should_notify) {
                        $alerte = new Alerte();
                        $message = 'Anomalie dans ';
                        if ($visit->network) {
                            $network_type = $visit->network->type;
                            if ($network_type->code == 'franchise' || $network_type->code == 'boutique' || $network_type->code == 'smart') {
                                $message .= ' la ' . $network_type->value . ' ' . $visit->network->name . " \n";
                                $message .= ' Tâche: ' . $answer->task->description;
                            } else {
                                $message .= ' le ' . $network_type->value . ' ' . $visit->network->name . " \n";
                                $message .= ' Tâche: ' . $answer->task->description;
                            }
                        }
                        $alerte->message = nl2br($message);
                        $alerte->target_type = 'task';
                        $alerte->target_id = $visit->id;
                        $alerte->seen = false;
                        $alerte->save();

                        $this->_sendEmail($alerte);
                    }
                }
                $answer->save();
                $photo_input_name = 'picture' . $i;
                if (Input::file($photo_input_name) !== null) {
                    $date = \Carbon\Carbon::now();
                    $timestamp = $date->timestamp;
                    $uploaded_photo = Input::file($photo_input_name);
                    if (!(substr($uploaded_photo->getMimeType(), 0, 5) == 'image')) {
                        return redirect()->back()->withErrors(array(
                            'error' => 'type de photo non pris en charge'
                        ));
                    }
                    $picture = new Photo();
                    $picture->type = 'task';
                    $picture->path = 'daily/' . $timestamp . $uploaded_photo->getClientOriginalName();
                    $picture->photo_set_id = $photo_set->id;
                    $picture->save();
                    $answer->photo_id = $picture->id;
                    $answer->save();
                    $img = Image::make($uploaded_photo->getRealPath());
                    $img->save(public_path('photos/' . $picture->path));
                    $img->save();
                }
            }
            $total = $ok + $ko;
            $ko_percent = 0;
            $ok_percent = 0;
            if ($total != 0) {
                $ko_percent = ($ko / $total) * 100;
                $ok_percent = ($ok / $total) * 100;
            }
            $visit->anomalies = $ko_percent;
            $visit->bmerch = $ok_percent;
            $visit->is_answered = true;
            $visit->comment = $request->note_on_visit ? nl2br($request->note_on_visit) : null;
            $visit->save();
            if ($visit->network && ($visit->network->type->code == 'smart' || $visit->network->type->code == 'franchise' || $visit->network->type->code == 'boutique')) {
                if ($ko_percent > 20) {
                    $alerte = new Alerte();
                    $message = "Taux d'anomalie élevé dans ";
                    $message .= ' la ' . $visit->network->type->value . ' ' . $visit->network->name;
                    $alerte->message = $message;
                    $alerte->target_type = 'visit';
                    $alerte->target_id = $visit->id;
                    $alerte->seen = false;
                    $alerte->save();

                    $this->_sendEmail($alerte);
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

                    $this->_sendEmail($alerte);
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

                    $this->_sendEmail($alerte);
                }
            }
        }

        DB::commit();
        Log::info('[Web] Answer added for daily visit ' . $visit->id . ' sent from : ' . Access::user()->name);

        return redirect('visits/daily/' . $visit->id);
    }

    public function edit($id)
    {
        $visit = Visit::find($id);
        if (!$visit->is_answered) {
            return redirect()->back();
        }
        if (Access::hasRole('Merch')) {
            $now = Carbon::now();
            $visit_date = new Carbon($visit->updated_at);
            $visit_date->addDay(1);
            if ($visit_date < $now) {
                return redirect()->back();
            }
        }

        return view('frontend.daily.edit', array(
            'visit' => $visit
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $visit = Visit::find($id);
        if ($visit->photoSet == null) {
            $photo_set = new Photoset();
            $photo_set->category = 'daily';
            $photo_set->visit_id = $id;
            $photo_set->save();
        }

        $answers_number = count($request->answer_id);
        $ok = 0;
        $ko = 0;
        for ($i = 0; $i < $answers_number; $i++) {
            $answer = Answer::find($request->answer_id[$i]);
            $answer->value = $request->radio[$i];
            $answer->comment = $request->remark[$i];
            if ($request->radio[$i] == 'ok') {
                $ok++;
            } else if ($request->radio[$i] == 'ko') {
                $ko++;
                if ($answer->task && $answer->task->should_notify) {
                    $alerte = new Alerte();
                    $message = 'Anomalie dans';
                    if ($visit->network) {
                        $network_type = $visit->network->type;
                        if ($network_type->code == 'franchise' || $network_type->code == 'boutique' || $network_type->code == 'smart') {
                            $message .= ' la ' . $network_type->value . ' ' . $visit->network->name . "\n";
                            $message .= ' Tâche: ' . $answer->task->description;
                        } else {
                            $message .= ' le ' . $network_type->value . ' ' . $visit->network->name . "\n";
                            $message .= ' Tâche: ' . $answer->task->description;
                        }

                    }
                    $alerte->message = nl2br($message);
                    $alerte->target_type = 'task';
                    $alerte->target_id = $visit->id;
                    $alerte->seen = false;
                    $alerte->save();

                    $this->_sendEmail($alerte);
                }
            }
            $answer->save();
            $photo_input_name = 'picture' . $i;
            if (Input::file($photo_input_name) !== null) {
                $date = \Carbon\Carbon::now();
                $timestamp = $date->timestamp;
                $uploaded_photo = Input::file($photo_input_name);
                if (!(substr($uploaded_photo->getMimeType(), 0, 5) == 'image')) {
                    return redirect()->back()->withErrors(array(
                        'error' => 'type de photo non pris en charge'
                    ));
                }
                $picture = new Photo();
                $picture->type = 'task';
                $picture->path = 'daily/' . $timestamp . $uploaded_photo->getClientOriginalName();
                $picture->photo_set_id = $visit->photoSet->id;
                $picture->save();
                $answer->photo_id = $picture->id;
                $answer->save();
                $img = Image::make($uploaded_photo->getRealPath());
                $img->save(public_path('photos/' . $picture->path));
                $img->save();
            }
        }
        $total = $ok + $ko;
        $ko_percent = 0;
        $ok_percent = 0;
        if ($total != 0) {
            $ko_percent = ($ko / $total) * 100;
            $ok_percent = ($ok / $total) * 100;
        }
        $visit->anomalies = $ko_percent;
        $visit->bmerch = $ok_percent;
        $visit->is_answered = true;
        $visit->comment = $request->note_on_visit ? nl2br($request->note_on_visit) : null;
        $visit->save();
        if ($visit->network && ($visit->network->type->code == 'franchise' || $visit->network->type->code == 'boutique')) {
            if ($ko_percent > 20) {
                $alerte = new Alerte();
                $message = "Taux d'anomalie élevé dans ";
                $message .= ' la ' . $visit->network->type->value . ' ' . $visit->network->name;
                $alerte->message = $message;
                $alerte->target_type = 'visit';
                $alerte->target_id = $visit->id;
                $alerte->seen = false;
                $alerte->save();

                $this->_sendEmail($alerte);
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

                $this->_sendEmail($alerte);
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

                $this->_sendEmail($alerte);
            }
        }
        DB::commit();
        Log::warning('[Web] Visit ' . $visit->id . ' edited by : ' . Access::user()->name);

        return redirect('visits/daily/' . $visit->id);
    }

    public function show($type, $id)
    {
        $visit = Visit::find($id);

        return view('frontend. ' . $type . '.detail', array(
            'visit' => $visit
        ));
    }

    public function destroy($id)
    {

    }

    private function _sendEmail($alerte)
    {
        /*$setting = Setting::where('user_id', null)
            ->where('value', 'notify_mail')
            ->first();
        if ($setting && $setting->code = 'yes') {
            $supervisor_role = Role::where('name', 'Superviseur')->first();
            $admin_role = Role::where('name', 'Administrator')->first();
            $users_to_notify = [];
            foreach ($supervisor_role->users as $user) {
                $users_to_notify[] = $user;
            }
            foreach ($admin_role->users as $user) {
                $users_to_notify[] = $user;
            }
            foreach ($users_to_notify as $user) {
                Mail::send('frontend.emails.alert', ['alerte' => $alerte], function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject("Alerte d'orange Merchandiser !");
                });
            }
        } else {
            $settings = Setting::where('value', 'notify_mail')
                ->get();
            foreach ($settings as $setting) {
                if ($setting->code == 'yes') {
                    $user = User::find($setting->user_id);
                    Mail::send('frontend.emails.alert', ['alerte' => $alerte], function ($message) use ($user) {
                        $message->to($user->email, $user->name)->subject("Alerte d'orange Merchandiser !");
                    });
                }
            }
        }
*/
        return true;
    }
}
