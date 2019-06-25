<?php

namespace App\Http\Controllers\API\v2;

use App\Models\Access\User\User;
use App\Models\MessageSeen;
use App\Models\Note;
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
use App\Models\Message;
use App\Models\Photo;
use App\Models\Access\Role\Role;

class MessageAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getMyMessages()
    {
        $date_historique = Carbon::now()->subDay(7);
        $user = Access::user();

        $messages = Message::where(function ($query) use ($user) {
            $query->where('receiver_id', $user->id)
                ->orWhere('sender_id', $user->id);
        })
            ->whereNotNull('receiver_id')
            ->where('created_at', '>', $date_historique)
            ->get();

        foreach ($messages as $msg) {
            $msg->is_seen = true;
            $msg->date_seen = Carbon::now();
            $msg->save();
        }

        return $messages;
    }

    public function getNotesService()
    {
        $notes = Note::where('merch_id', 0)
            ->where('target_type', 'service')
            ->orderBy('created_at', 'DESC')
            ->take(20)
            ->get();

        return $notes;
    }

    public function getNotesSuperviseur()
    {
        $user = Access::user();
        $notes = Note::where('merch_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->take(20)
            ->get();

        return $notes;
    }

    public function getNoteDetails(Request $request)
    {
        $data = $request->json()->all();
        $note_id = $data['note_id'];
        $user = Access::user();

        $note = Note::find($note_id);
        if(!$note){
            Log::notice('[API v2] Error: Invalid Note : ' . $note_id . ' '. Access::user()->name);
            abort(406, 'Invalid note');
        }
        $result = null;
        switch ($note->target_type) {
            case 'visit': $result = Visit::find($note->target_id);
                break;
            case 'task': $result = Answer::find($note->target_id);
                break;
            case 'photo': $result = Photo::find($note->target_id);
                break;
            default: break;
        }

        return response()->json(['note' => $note, 'type' => $note->target_type, 'details' => $result]);
    }

    public function getUsers()
    {
        /*$fields = ['users.id', 'users.name', 'users.email'];
        $superviseur = Role::where('name', 'Superviseur')->first()->users()->get($fields);
        $admins = Role::where('name', 'Administrator')->first()->users()->get($fields);
        $users = $admins->merge($superviseur);*/
        $users = User::all(array('id', 'name', 'email'));
        return $users;
    }

    public function addMessage(Request $request)
    {
        $data = $request->json()->all();
        $sender = Access::user();
        //$receiver = User::find($data['receiver_id']);
        $text = $data['message'];


        DB::beginTransaction();
        $message = new Message();
        $message->sender_id = $sender->id;
        $message->receiver_id = 0;
        $message->message = $text;
        $message->save();
        DB::commit();
        return response()->json(['response' => 'ok', 'message_id' => $message->id]);
    }

    public function addMessageSeen(Request $request)
    {
        $data = $request->json()->all();
        $user = Access::user();

        DB::beginTransaction();

        if (array_key_exists('message_id', $data)) {
            $message = Message::find($data['message_id']);
            $message->is_seen = true;
            $message->date_seen = Carbon::now();
            $message->save();

        } else {
            $messages = Message::where('receiver_id', $user->id)
                ->where('is_seen', false)->get();
            foreach ($messages as $msg) {
                $msg->is_seen = true;
                $msg->date_seen = Carbon::now();
                $msg->save();
            }
        }


        DB::commit();
        return response()->json(['response' => 'ok']);
    }

    public function addNoteSeen(Request $request)
    {
        $data = $request->json()->all();
        $user = Access::user();

        DB::beginTransaction();


        if (array_key_exists('note_id', $data)) {
            $message = Note::find($data['note_id']);
            $messageSeen = new MessageSeen();
            $messageSeen->message_id = $message->id;
            $messageSeen->user_id = $user->id;
            $messageSeen->save();
        } else {
            $notes = Notes::where('target_type', 'service')
                ->where('merch_id', 0)
                ->get();
            foreach ($notes as $msg) {
                $messageSeen = new MessageSeen();
                $messageSeen->message_id = $msg->id;
                $messageSeen->user_id = $user->id;
                $messageSeen->save();
            }
        }

        DB::commit();
        return response()->json(['response' => 'ok']);
    }

}
