<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Access\Role\Role;
use App\Models\Answer;
use App\Models\Message;
use App\Models\MessageSeen;
use App\Models\Note;
use App\Models\Photo;
use App\Models\Visit;
use App\Services\Access\Facades\Access;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\GCM;
use App\Jobs\sendPushNotification;

class CommentController extends Controller
{
    public function index()
    {
        return view('frontend.note.list');
    }

    public function addNoteForVisit(Request $request, $id)
    {
        DB::beginTransaction();

        $visit = Visit::find($id);
        if ($visit->is_answered || $visit->is_answered_branding || $visit->is_answered_display || $visit->is_answered_online || $visit->is_answered_ilv) {
            $note = New Note();
            $note->target_type = 'visit';
            $note->visit_id = $visit->id;
            $network = $visit->network ? ' ' . $visit->network->name : '';
            $object = 'Note sur visite (' . $network . ' le ' . $visit->updated_at->format('Y-m-d') . ')';
            $note->object = $object;
            $note->message = $request->message ? nl2br($request->message) : '';
            $note->supervisor_id = \Auth::user()->id;
            $note->merch_id = $visit->user ? $visit->user->id : null;
            $note->target_id = $visit->id;
            $note->save();
            if ($note->merch_id) {
                $gcm = GCM::where('user_id', $note->merch_id)->first();
                if ($gcm)
                    $this->dispatch(new sendPushNotification($gcm->token, 'note.superviseur', $gcm->user_id));
            }
        }
        DB::commit();
        return redirect()->back();
    }

    public function addCommentForVisit(Request $request)
    {
        $id = $request->visit_id;
        $comment = $request->message;
        $visit = $id ? Visit::find($id) : null;

        if ($visit) {
            DB::beginTransaction();
            $visit->comment = nl2br($comment);
            $visit->save();
            DB::commit();
        }

        return redirect()->back();
    }

    public function addNoteForPicture(Request $request)
    {
        DB::beginTransaction();
        $notes_number = $request->picture_id ? count($request->picture_id) : '';
        for ($i = 0; $i < $notes_number; $i++) {
            if ($request->picture_id[$i] != '') {
                $has_note = $request->note[$i] != '' ? nl2br($request->note[$i]) : null;
                if ($has_note) {
                    $photo = Photo::find($request->picture_id[$i]);
                    $visit = $photo->photoSet->visit;
                    $note = New Note();
                    $note->target_type = 'photo';
                    $note->visit_id = $visit->id;
                    $network = $visit->network ? ' ' . $visit->network->name : '';
                    $object = 'Note sur photo (' . $network . ' le ' . $visit->updated_at->format('Y-m-d') . ')';
                    $note->object = $object;
                    $note->message = $request->note[$i] != '' ? nl2br($request->note[$i]) : '';
                    $note->supervisor_id = \Auth::user()->id;
                    $note->merch_id = $visit->user ? $visit->user->id : null;
                    $note->target_id = $photo->id;
                    $note->save();
                    if ($note->merch_id) {
                        $gcm = GCM::where('user_id', $note->merch_id)->first();
                        if ($gcm)
                            $this->dispatch(new sendPushNotification($gcm->token, 'note.superviseur', $gcm->user_id));
                    }
                }
            }
        }
        DB::commit();

        return redirect()->back();
    }

    public function addNoteForAnswer(Request $request, $id)
    {
        DB::beginTransaction();
        $answer = Answer::find($id);
        $visit = $answer->visit;
        $note = New Note();
        $note->target_type = 'task';
        $note->visit_id = $visit->id;
        $network = $visit->network ? ' ' . $visit->network->name : '';
        $object = 'Note sur une tâche (' . $network . ' le ' . $visit->updated_at->format('Y-m-d') . ')';
        $note->object = $object;
        $note->message = $request->answer_note ? nl2br($request->answer_note) : '';
        $note->supervisor_id = \Auth::user()->id;
        $note->merch_id = $visit->user ? $visit->user->id : null;
        $note->target_id = $answer->id;
        $note->save();
        DB::commit();
        if ($note->merch_id) {
            $gcm = GCM::where('user_id', $note->merch_id)->first();
            if ($gcm)
                $this->dispatch(new sendPushNotification($gcm->token, 'note.superviseur', $gcm->user_id));
        }
        return redirect()->back();
    }

    public function addCommentForAnswer(Request $request, $id)
    {
        $comment = $request->task_comment ? nl2br($request->task_comment) : '';
        $answer = Answer::find($id);
        $answer->comment = $comment;
        $answer->save();

        return redirect()->back();
    }

    public function create()
    {
        return view('frontend.note.add');
    }

    public function addServiceNote(Request $request)
    {
        DB::beginTransaction();
        $note = New Note();
        $note->target_type = 'service';
        $note->visit_id = null;
        $object = $request->object ? nl2br($request->object) : 'Note de service';
        $note->object = $object;
        $note->message = $request->note ? nl2br($request->note) : '';
        $note->supervisor_id = \Auth::user()->id;
        $note->merch_id = 0;
        $note->target_id = null;
        $note->save();
        DB::commit();

        $gcms = GCM::all();
        foreach ($gcms as $gcm) {
            $this->dispatch(new sendPushNotification($gcm->token, 'note.service', $gcm->user_id));
        }

        return redirect('/service/note/' . $note->id);
    }

    public function edit($id)
    {
        $note = Note::find($id);

        return view('frontend.note.edit', array(
            'note' => $note
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $note = Note::find($id);
        $note->target_type = 'service';
        $object = $request->object ? nl2br($request->object) : 'Note de service';
        $note->object = $object;
        $note->message = $request->note ? nl2br($request->note) : '';
        $note->supervisor_id = \Auth::user()->id;
        $note->save();

        $views = $note->views;
        foreach ($views as $view) {
            $view->delete();
        }
        DB::commit();
        return redirect('/service/note/' . $note->id);
    }

    public function show($id)
    {
        $current_user = \Auth::user();
        $message_seen = MessageSeen::where('user_id', $current_user->id)
            ->where('message_id', $id)
            ->first();
        if ($message_seen == null) {
            $new_sight = new MessageSeen();
            $new_sight->message_id = $id;
            $new_sight->user_id = $current_user->id;
            $new_sight->save();
        }

        $message = Note::find($id);
        return view('frontend.note.detail', array(
            'message' => $message
        ));
    }

    public function delete($id)
    {
        $note = Note::find($id);

        return view('frontend.note.confirm-delete', array(
            'note' => $note
        ));
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        $views = $note->views;
        foreach ($views as $view) {
            $view->delete();
        }
        $note->delete();

        return redirect('/service/note');
    }

    public function getNotes(Request $request)
    {

        $notes = Note::where('merch_id', 0)
            ->where('target_type', 'service')
            ->paginate($request->length);
        $notes_number = $notes->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $notes_number,
            "recordsFiltered" => $notes_number,
        ];

        $results["data"] = array();
        foreach ($notes as $note) {
            if (Access::hasRoles('Merch', 'Visiteur')) {
                $actions = '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/service/note/" . $note->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>';
            } else {
                $actions = '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/service/note/" . $note->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>' .
                    '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/service/note/edit/" . $note->id) . '"><i
                                                        class="fa fa-edit"></i> Edit</a>' .
                    '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/service/note/delete/" . $note->id) . '"><i
                                                        class="fa fa-trash"></i> Supprimer</a>';
            }
            $results["data"][] = array(
                $note->created_at ? $note->created_at->format('d/m/Y') : '',
                $note->supervisor ? $note->supervisor->name : '',
                $note->message ? strip_tags($note->object) : '',
                $actions
            );
        }

        return $results;
    }

}
