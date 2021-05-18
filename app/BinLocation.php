<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinLocation extends Model
{
    protected $primaryKey = 'id_bin_location';
    protected $fillable = [
        'rack_id',
        'bin_location_name',
    ];

    public function rack()
    {
        return $this->belongsTo('App\Rack', 'rack_id', 'id_rack');
    }

    public function bin()
    {
        return $this->hasMany('App\Bin', 'bin_location_id', 'id_bin_location');
    }
}
