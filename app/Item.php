<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'id_item';
    protected $fillable = [
        'bin_id',
        'item_code',
        'item_name',
        'unit',
    ];

    public function bin()
    {
        return $this->belongsTo('App\Bin', 'bin_id', 'id_bin');
    }

    public function mutation()
    {
        return $this->hasMany('App\Mutation', 'item_id', 'id_item');
    }
}
