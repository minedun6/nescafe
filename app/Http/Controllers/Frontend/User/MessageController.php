<?php

namespace App\Http\Controllers\Frontend\User;

use App\Jobs\sendPushNotification;
use App\Models\Access\User\User;
use App\Models\GCM;
use App\Models\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Access\Role\Role;
use App\Http\Controllers\Controller;
use App\Services\Access\Facades\Access;

class MessageController extends Controller
{
    public function index()
    {
        $data = [];
        if (!Access::hasRole('Merch')) {
            $merch_role = Role::where('name', 'Merch')->first();
            $merchandisers = $merch_role->users;
            $data = [
                'merchandisers' => $merchandisers
            ];
        }

        return view('frontend.chat.chat', $data);
    }

    public function send(Request $request)
    {
        $sent_message = $request->message != '' ? nl2br($request->message) : '';
        $receiver = $request->receiver_id != '' ? User::find($request->receiver_id) : null;

        if ($receiver != null) {
            $receiver_id = $receiver->id;
            $gcm = GCM::where('user_id', $receiver_id)->first();
            if ($gcm)
                $this->dispatch(new sendPushNotification($gcm->token, 'message', $receiver_id));
        } else {
            $receiver_id = 0;
        }
        $now = \Carbon\Carbon::now();

        $message = new Message();
        $message->sender_id = \Auth::user()->id;
        $message->receiver_id = $receiver_id;
        $message->is_seen = false;
        $message->message = $sent_message;
        $message->save();

        return [
            'name' => $message->sender->name,
            'message' => $message->message,
            'time' => $message->created_at ? $now->subSeconds($now->timestamp - $message->created_at->timestamp)->diffForHumans() : ''
        ];
    }

    public function getMessages(Request $request)
    {
        $merch_id = $request->merch_id;
        $messages = Message::where(function ($query) use ($merch_id) {
            $query->where('receiver_id', $merch_id)
                ->orWhere('sender_id', $merch_id);
        })
            ->whereNotNull('receiver_id')
            ->orderBy('created_at')
            ->get();
        $discussion = [];
        $today = \Carbon\Carbon::now();
        foreach ($messages as $message) {
            if (Access::hasRole('Merch') && !$message->is_seen) {
                $message->is_seen = true;
                $message->date_seen = $today;
                $message->save();
            }

            $discussion[] = [
                'name' => $message->sender->name,
                'sender_id' => $message->sender_id,
                'is_seen' => $message->is_seen,
                'date_seen' => $message->date_seen ? $message->date_seen->format('d/m/Y à H:i') : '',
                'message' => strip_tags($message->message),
                'time' => $message->created_at ? $today->subSeconds($today->timestamp - $message->created_at->timestamp)->diffForHumans() : ''
            ];

        }
        return $discussion;
    }
}
