<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    public $timestamps = false;
    protected $fillable =
    [
    'name',
    'address',
    'lat',
    'lng',
    'type',
    'size',
    'price',
    'kraj'
    ];
}
