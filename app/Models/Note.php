<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $dates = ['created_at', 'updated_at'];

    public function supervisor()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'supervisor_id');
    }

    public function merch()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'merch_id');
    }

    public function views()
    {
        return $this->hasMany('App\Models\MessageSeen', 'message_id');
    }
}
