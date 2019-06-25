<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ILV extends Model
{
    use SoftDeletes;
    protected $table = 'ilvs';
    protected $fillable = [
        'target', 'network_type_id', 'photo_id', 'name'
    ];
    protected $dates = [
        'updated_at', 'created_at', 'deleted_at'
    ];
    protected $casts = ['should_notify' => 'boolean'];

    public function networkType()
    {
        return $this->belongsTo('App\Models\NetworkType', 'network_type_id');
    }

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo', 'photo_id');
    }

    public function stock()
    {
        return $this->hasMany('App\Models\Approvisionnement', 'ilv_id');
    }

    public function history()
    {
        return $this->hasMany('App\Models\ILVNetwork', 'ilv_id');
    }
}
