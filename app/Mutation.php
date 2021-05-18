<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $primaryKey = 'id_mutation';
    protected $fillable = [
        'item_id',
        'user_id',
        'qty',
        'transtype',
    ];

    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id', 'id_item');
    }

}
