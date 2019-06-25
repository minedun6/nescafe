<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PDV extends Model
{
    protected $table = 'pdvs';
    protected $fillable = [
        'sector', 'cds', 'network_id'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function network()
    {
        return $this->belongsTo('App\Models\Network', 'network_id');
    }
}
