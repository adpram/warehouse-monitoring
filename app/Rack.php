<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $primaryKey = 'id_rack';
    protected $fillable = [
        'area_id',
        'rack_name',
    ];

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id', 'id_area');
    }

    public function binlocation()
    {
        return $this->belongsTo('App\BinLocation', 'id_rack', 'rack_id');
    }
}
