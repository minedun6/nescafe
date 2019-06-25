<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = [
        'value', 'comment'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function task()
    {
        return $this->belongsTo('App\Models\Task', 'task_id');
    }

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo', 'photo_id');
    }

    public function note_task()
    {
        return $this->hasOne('App\Models\Note', 'target_id')->where('target_type', 'task');
    }

    public function visit()
    {
        return $this->belongsTo('App\Models\Visit', 'visit_id');
    }
}
