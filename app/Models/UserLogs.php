<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    protected $table = 'user_logs';
    protected $fillable = [
        'user_id', 'target', 'target_id'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }

}
