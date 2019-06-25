<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';
    protected $fillable = [
        'type', 'city_id'
    ];
    protected $dates = ['created_at', 'updated_at', 'visit_date'];

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User', 'user_id');
    }

    public function network()
    {
        return $this->belongsTo('App\Models\Network', 'network_id');
    }

    public function checkList()
    {
        return $this->belongsTo('App\Models\CheckList', 'check_list_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'visit_id')->orderBy('task_id', 'ASC');
    }

    public function photoSet()
    {
        return $this->hasOne('App\Models\Photoset', 'visit_id');
    }

    public function note_visit()
    {
        return $this->hasOne('App\Models\Note', 'target_id')->where('target_type', 'visit');
    }

    public function note_checklist()
    {
        return $this->hasOne('App\Models\Note', 'target_id')->where('target_type', 'visit');
    }

    public function ilvNetworks()
    {
        return $this->hasMany('App\Models\ILVNetwork', 'visit_id');
    }

}
