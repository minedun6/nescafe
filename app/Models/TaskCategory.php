<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $table = 'task_gategories';
    protected $fillable = [
        'name'
    ];
    protected $dates = ['created_at', 'updated_at'];
}
