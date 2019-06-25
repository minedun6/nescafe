<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $table = 'tasks';
    protected $fillable = [
        'description'
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'should_notify' => 'boolean'
    ];

    public function taskSubCategory()
    {
        return $this->belongsTo('App\Models\TaskSubCategory', 'task_sub_category_id');
    }

    public function note_task()
    {
        return $this->hasOne('App\Models\Note', 'target_id')->where('target_type', 'task');
    }

    public function checkList()
    {
        return $this->belongsTo('App\Models\CheckList', 'check_list_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'task_id');
    }
}
