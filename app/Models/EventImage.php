<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'image',
    ];

    protected $appends = ['image_url'];

    public function event()
    {
        return $this->belongsTo(Event::class);
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
