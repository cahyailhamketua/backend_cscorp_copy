<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sosmed extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sosmed',
        'url',
        'icon',
    ];

    protected $appends = [
        'icon_class',
    ];

    /**
     * Get icon class attribute (FontAwesome icon based on platform)
     */
    protected function iconClass(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // If custom icon is set, use it
                if (! empty($attributes['icon'])) {
                    return $attributes['icon'];
                }

                // Map platform names to FontAwesome icon classes
                $platform = strtolower($attributes['nama_sosmed'] ?? '');

                $iconMap = [
                    'instagram' => 'fab fa-instagram',
                    'facebook' => 'fab fa-facebook',
                    'twitter' => 'fab fa-twitter',
                    'linkedin' => 'fab fa-linkedin',
                    'tiktok' => 'fab fa-tiktok',
                    'youtube' => 'fab fa-youtube',
                    'whatsapp' => 'fab fa-whatsapp',
                    'telegram' => 'fab fa-telegram',
                    'github' => 'fab fa-github',
                    'dribbble' => 'fab fa-dribbble',
                ];

                return $iconMap[$platform] ?? 'fab fa-link';
            },
        );
    }
}
