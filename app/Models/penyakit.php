<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class penyakit extends Model
{
    use HasFactory;
    protected $collection = 'penyakit';
    protected $fillable = ['nama_penyakit', 'nama_ilmiah', 'deskripsi', 'penanganan', 'penanggulangan', 'jumlah dataset', 'thumbnail'];
}
