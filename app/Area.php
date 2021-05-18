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
        return $this->hasMany('App\Rack', 'area_id', 'id_area');
    }
}
