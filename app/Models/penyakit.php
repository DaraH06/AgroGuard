<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class penyakit extends Model
{
    protected $collection = 'penyakit';
    protected $fillable = ['nama_penyakit', 'inang'];
}
