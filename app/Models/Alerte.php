<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    protected $table = 'alertes';
    protected $fillable = [
        'message', 'target_id', 'target_type'
    ];
    protected $casts = ['seen' => 'boolean'];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
