<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'name'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function zone()
    {
        return $this->belongsTo('App\Models\Zone', 'zone_id');
    }
}
