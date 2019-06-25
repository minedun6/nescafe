<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'code', 'value', 'user_id'
    ];
    protected $dates = [
        'created_at', 'deleted_at'
    ];
}
