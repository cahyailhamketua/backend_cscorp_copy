<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_client',
        'icon',
    ];

    protected $appends = [
        'icon_url',
    ];

    /**
     * Get icon url attribute (full asset url with clients/ folder)
     */
    protected function iconUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $icon = $attributes['icon'] ?? null;
                if (empty($icon)) {
                    return null;
                }

                // Remove leading slash if exists
                $icon = ltrim($icon, '/');

                // Remove all 'clients/' prefixes (including nested) to avoid duplication
                $fileName = preg_replace('#^(clients/)+#', '', $icon);

                // If icon already has 'productions/' prefix, use it directly
                if (str_starts_with($icon, 'productions/')) {
                    return asset('storage/'.$icon);
                }

                $disk = Storage::disk('public');

                // Try clients folder first (for new uploads)
                if ($disk->exists('clients/'.$fileName)) {
                    return asset('storage/clients/'.$fileName);
                }

                // Fallback for legacy uploads in productions folder
                if ($disk->exists('productions/'.$fileName)) {
                    return asset('storage/productions/'.$fileName);
                }

                // Last fallback: file at root of public disk
                if ($disk->exists($fileName)) {
                    return asset('storage/'.$fileName);
                }

                return null;
            },
        );
    }
}
