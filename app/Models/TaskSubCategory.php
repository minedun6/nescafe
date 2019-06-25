<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubCategory extends Model
{
    protected $table = 'task_sub_gategories';
    protected $fillable = [
        'name'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function taskCategory()
    {
        return $this->belongsTo('App\Models\TaskCategory', 'task_category_id');
    }
}
