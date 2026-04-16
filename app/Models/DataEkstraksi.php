<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DataEkstraksi extends Model
{
    protected $collection = 'data_ekstraksi';
    protected $fillable = ['Red', 'Green', 'Blue', 'G_std', 'ExG', 'Label'];
}
