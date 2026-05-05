<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Satu record = satu page view dari pengunjung.
 */
class Visitor extends Model
{
    /** @var bool Menggunakan visited_at saja (tanpa created_at/updated_at otomatis) */
    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'ip_address',
        'user_agent',
        'browser',
        'device_type',
        'url',
        'method',
        'referer',
        'visited_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }

    /**
     * Agregasi COUNT(DISTINCT visitor_id) dalam rentang waktu (efisien untuk dashboard).
     */
    public static function distinctVisitorCount(CarbonInterface $from, CarbonInterface $to): int
    {
        return (int) DB::table('visitors')
            ->whereBetween('visited_at', [$from, $to])
            ->count(DB::raw('DISTINCT visitor_id'));
    }

    /**
     * Jumlah page view dalam rentang waktu.
     */
    public static function pageViewCount(CarbonInterface $from, CarbonInterface $to): int
    {
        return (int) static::query()
            ->whereBetween('visited_at', [$from, $to])
            ->count();
    }
}
