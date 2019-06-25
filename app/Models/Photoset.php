<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photoset extends Model
{
    protected $table = 'photo_sets';
    protected $fillable = [
        'category', 'photo_category_id'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function photos()
    {
        return $this->hasMany('App\Models\Photo', 'photo_set_id');
    }

    public function photoCategory()
    {
        return $this->belongsTo('App\Models\PhotoCategory', 'photo_category_id');
    }

    public function visit()
    {
        return $this->belongsTo('App\Models\Visit', 'visit_id');
    }
}
