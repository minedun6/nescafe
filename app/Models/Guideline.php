<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guideline extends Model
{
    use SoftDeletes;

    protected $table = 'guidelines';
    protected $fillable = [
        'nom', 'cible'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

}
