<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GCM extends Model
{
    protected $table = 'gcm';
    protected $fillable = [
        'token', 'user_id'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }
}
