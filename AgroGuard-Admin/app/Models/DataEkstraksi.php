<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class DataEkstraksi extends Model
{
    protected $collection = 'data_ekstraksi';
    protected $fillable = ['mean_r', 'mean_g', 'mean_b', 'exg', 'g_std', 'contrast', 'Label'];
}
