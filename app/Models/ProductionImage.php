<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'image',
    ];

    protected $appends = ['image_url'];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    /**
     * Get image URL - don't use mutator, use appended attribute
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->image ? asset('storage/'.$this->image) : null,
        );
    }
}
