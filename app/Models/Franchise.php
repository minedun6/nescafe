<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    protected $table = 'franchises';
    protected $fillable = [
        'time_open', 'time_close', 'time_open_sunday', 'time_close_sunday', 'network_id'
    ];
    protected $casts = ['is_sunday_open' => 'boolean'];
    protected $dates = ['created_at', 'updated_at'];

    public function network()
    {
        return $this->belongsTo('App\Models\Network', 'network_id');
    }
}
