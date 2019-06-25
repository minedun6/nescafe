<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    protected $table = 'check_lists';
    protected $fillable = [
        'name', 'visit_id'
    ];
    protected $dates = ['created_at', 'updated_at'];

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'check_list_id');
    }
}
