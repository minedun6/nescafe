<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FicheTechnique extends Model
{
    use SoftDeletes;

    protected $table = 'fiches_techniques';
    protected $fillable = [
        'nom', 'cible', 'category', 'subcategory', 'network_type_id'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];


    public function network_type()
    {
        return $this->belongsTo('App\Models\NetworkType', 'network_type_id');
    }
}
