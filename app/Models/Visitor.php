<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'page_visited',
        'referrer',
        'visit_count',
        'last_visit_at',
    ];

    protected $casts = [
        'last_visit_at' => 'datetime',
    ];

    // Get total unique visitors
    public static function getTotalUniqueVisitors()
    {
        return self::distinct('ip_address')->count('ip_address');
    }

    // Get total page views
    public static function getTotalPageViews()
    {
        return self::sum('visit_count');
    }

    // Get today's visitors
    public static function getTodayVisitors()
    {
        return self::whereDate('last_visit_at', today())->count();
    }

    // Get this month's visitors
    public static function getMonthlyVisitors()
    {
        return self::whereMonth('created_at', now()->month)
                   ->whereYear('created_at', now()->year)
                   ->count();
    }

    // Get visitor growth percentage
    public static function getGrowthPercentage($period = 'month')
    {
        if ($period === 'month') {
            $currentMonth = self::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->count();
            
            $lastMonth = self::whereMonth('created_at', now()->subMonth()->month)
                            ->whereYear('created_at', now()->subMonth()->year)
                            ->count();
            
            if ($lastMonth == 0) return 100;
            
            return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1);
        }
        
        return 0;
    }

    // Get visitors by date range
    public static function getVisitorsByDateRange($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
                   ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                   ->groupBy('date')
                   ->orderBy('date')
                   ->get();
    }

    // Get top browsers
    public static function getTopBrowsers($limit = 5)
    {
        return self::selectRaw('browser, COUNT(*) as count')
                   ->whereNotNull('browser')
                   ->groupBy('browser')
                   ->orderByDesc('count')
                   ->limit($limit)
                   ->get();
    }

    // Get top devices
    public static function getTopDevices()
    {
        return self::selectRaw('device_type, COUNT(*) as count')
                   ->whereNotNull('device_type')
                   ->groupBy('device_type')
                   ->get();
    }
}