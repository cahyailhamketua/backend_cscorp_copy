<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vision extends Model
{
    use HasFactory;

    protected $fillable = [
        'visi',
        'misi',
    ];
}
