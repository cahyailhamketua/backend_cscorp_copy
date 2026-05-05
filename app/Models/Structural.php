<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structural extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'image',
        'deskripsi',
    ];

    protected $appends = ['image_url'];

    public function skills()
    {
        return $this->hasMany(StructuralSkill::class);
    }

    public function sosmeds()
    {
        return $this->hasMany(StructuralSosmed::class);
    }

    /**
     * Get image URL accessor
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->image ? asset('storage/'.$this->image) : null,
        );
    }
}
