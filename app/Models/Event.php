<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'client',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function images()
    {
        return $this->hasMany(EventImage::class);
    }
}
