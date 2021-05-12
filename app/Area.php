<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $primaryKey = 'id_area';
    protected $fillable = [
        'area_name',
    ];

    public function rack()
    {
        return $this->belongsTo('App\Rack', 'id_area', 'area_id');
    }
}
