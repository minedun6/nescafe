<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageSeen extends Model
{
    protected $table = 'messages_seen';

    protected $dates = ['created_at', 'updated_at'];

    public function message()
    {
        return $this->belongsTo('App\Models\Message', 'message_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }
}
