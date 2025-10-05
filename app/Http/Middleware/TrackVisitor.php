<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking untuk admin routes
        if ($request->is('admin/*') || $request->is('dashboard*')) {
            return $next($request);
        }

        try {
            $agent = new Agent();
            $ip = $request->ip();
            $userAgent = $request->userAgent();

            // Cek apakah visitor sudah pernah berkunjung hari ini
            $visitor = Visitor::where('ip_address', $ip)
                ->whereDate('last_visit_at', today())
                ->first();

            if ($visitor) {
                // Update visit count
                $visitor->increment('visit_count');
                $visitor->update(['last_visit_at' => now()]);
            } else {
                // Create new visitor record
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'device_type' => $this->getDeviceType($agent),
                    'browser' => $agent->browser(),
                    'platform' => $agent->platform(),
                    'country' => null, // Integrasi GeoIP opsional
                    'city' => null,
                    'page_visited' => $request->path(),
                    'referrer' => $request->header('referer'),
                    'visit_count' => 1,
                    'last_visit_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // Log error tapi jangan hentikan request
            \Log::error('Visitor tracking error: ' . $e->getMessage());
        }

        return $next($request);
    }

    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isPhone()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } elseif ($agent->isDesktop()) {
            return 'desktop';
        }
        return 'unknown';
    }
}
