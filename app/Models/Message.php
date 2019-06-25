<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $dates = ['created_at', 'updated_at', 'date_seen'];

    public function sender()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'receiver_id');
    }

    public function views()
    {
        return $this->hasMany('App\Models\MessageSeen', 'message_id');
    }
}
