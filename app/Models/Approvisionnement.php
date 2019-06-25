<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    protected $table = 'approvisionnements';
    protected $fillable = [
        'ilv_id', 'quantity'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function ilv()
    {
        return $this->belongsTo('App\Models\ILV', 'ilv_id');
    }
}
