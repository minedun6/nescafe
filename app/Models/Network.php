<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $table = 'networks';
    protected $fillable = [
        'name', 'responsible', 'address', 'phone', 'phone2', 'land_line', 'postal_code', 'type_id'
    ];
    protected $date = ['created_at', 'updated_at'];

    public function pdv()
    {
        return $this->hasOne('App\Models\PDV', 'network_id');
    }

    public function franchise()
    {
        return $this->hasOne('App\Models\Franchise', 'network_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\NetworkType', 'type_id');
    }

    public function visits()
    {
        return $this->hasMany('App\Models\Visit', 'network_id');
    }
}
