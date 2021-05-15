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
        return $this->belongsTo('App\Bin', 'id_bin_location', 'bin_location_id');
    }
}
