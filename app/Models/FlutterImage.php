<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Str;

class FlutterImage extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'gambar_flutter';

    protected $fillable = [
        'image_path',
        'filename',
        'original_filename',
        'file_size',
        'mime_type',
        'uploaded_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'uploaded_at' => 'datetime',
    ];

    protected static function booting()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::ulid();
            }
            if (!$model->uploaded_at) {
                $model->uploaded_at = now();
            }
        });
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
