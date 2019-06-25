<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkType extends Model
{
    protected $table = 'network_types';
    protected $fillable = [
        'code', 'value'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function networks()
    {
        return $this->hasMany('App\Models\Network', 'type_id');
    }
}
