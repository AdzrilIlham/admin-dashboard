<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya track di public routes, skip admin routes
        if (!$request->is('admin/*') && !$request->is('login') && !$request->is('register')) {
            
            // Get portfolio owner (user pertama atau bisa dari settings)
            $owner = User::first();
            
            if ($owner) {
                // Detect device info menggunakan Agent
                $agent = new Agent();
                
                // Cek apakah IP ini sudah visit hari ini (optional: untuk avoid duplicate)
                $ipAddress = $request->ip();
                $todayVisit = Visitor::where('ip_address', $ipAddress)
                                    ->whereDate('created_at', today())
                                    ->exists();
                
                // Hanya catat jika belum visit hari ini (atau hapus if ini jika mau track setiap visit)
                if (!$todayVisit) {
                    Visitor::create([
                        'user_id' => $owner->id,
                        'ip_address' => $ipAddress,
                        'user_agent' => $request->userAgent(),
                        'device' => $this->getDevice($agent),
                        'browser' => $agent->browser(),
                        'os' => $agent->platform(),
                        'referrer' => $request->header('referer'),
                        'page_visited' => $request->path(),
                    ]);
                }
            }
        }
        
        return $next($request);
    }
    
    /**
     * Detect device type
     */
    private function getDevice(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'Mobile';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isDesktop()) {
            return 'Desktop';
        }
        return 'Unknown';
    }
}