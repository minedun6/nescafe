<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    protected $dates = [
        'updated_at', 'created_at', 'deleted_at'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\City', 'zone_id');
    }
}