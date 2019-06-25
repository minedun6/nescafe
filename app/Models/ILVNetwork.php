<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ILVNetwork extends Model
{
    protected $table = 'ilv_networks';
    protected $fillable = [
        'network_id', 'ilv_id', 'status'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $casts = ['status' => 'boolean'];

    public function network()
    {
        return $this->belongsTo('App\Models\Network', 'network_id');
    }

    public function ilv()
    {
        return $this->belongsTo('App\Models\ILV', 'ilv_id');
    }
}
