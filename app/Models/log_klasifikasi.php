<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class log_klasifikasi extends Model
{
    const UPDATED_AT = null;
    use HasFactory;
    protected $collection = 'log_klasifikasi';
    protected $guarded = [];


}
