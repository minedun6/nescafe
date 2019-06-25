<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = [
        'path', 'type', 'description'
    ];
    protected $dates = [
        'created_at', 'updated_at', 'photo_date'
    ];

    public function photoSet()
    {
        return $this->belongsTo('App\Models\Photoset', 'photo_set_id');
    }

    public function note_photo()
    {
        return $this->hasOne('App\Models\Note', 'target_id')->where('target_type', 'photo');
    }
}
