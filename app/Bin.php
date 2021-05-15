<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bin extends Model
{
    protected $primaryKey = 'id_bin';
    protected $fillable = [
        'bin_location_id',
        'bin_name',
    ];

    public function binlocation()
    {
        return $this->belongsTo('App\BinLocation', 'bin_location_id', 'id_bin_location');
    }
}
