<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructuralSosmed extends Model
{
    use HasFactory;

    protected $fillable = [
        'structural_id',
        'nama_sosmed',
        'icon_class',
        'url',
    ];

    // Mapping nama sosmed ke icon class (Font Awesome)
    public static function getIconMapping()
    {
        return [
            'Instagram' => 'fab fa-instagram',
            'Facebook' => 'fab fa-facebook',
            'Twitter' => 'fab fa-twitter',
            'LinkedIn' => 'fab fa-linkedin',
            'TikTok' => 'fab fa-tiktok',
            'YouTube' => 'fab fa-youtube',
            'WhatsApp' => 'fab fa-whatsapp',
            'Telegram' => 'fab fa-telegram',
            'GitHub' => 'fab fa-github',
            'Dribbble' => 'fab fa-dribbble',
        ];
    }

    // Auto-generate icon class saat save
    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->icon_class) {
                $iconMap = self::getIconMapping();
                $model->icon_class = $iconMap[$model->nama_sosmed] ?? 'fas fa-link';
            }
        });

        static::updating(function ($model) {
            if (! $model->icon_class) {
                $iconMap = self::getIconMapping();
                $model->icon_class = $iconMap[$model->nama_sosmed] ?? 'fas fa-link';
            }
        });
    }

    public function structural()
    {
        return $this->belongsTo(Structural::class);
    }
}
