<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructuralSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'structural_id',
        'pengalaman',
    ];

    public function structural()
    {
        return $this->belongsTo(Structural::class);
    }
}
