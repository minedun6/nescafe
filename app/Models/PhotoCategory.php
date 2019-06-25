<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model
{
    protected $table = 'photo_categories';
    protected $fillable = [
        'code', 'value'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function networkType()
    {
        return $this->belongsTo('App\Models\NetworkType', 'network_type_id');
    }
}
