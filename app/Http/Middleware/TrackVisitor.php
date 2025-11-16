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
        // Jalankan request lebih dulu dan simpan responsenya
        $response = $next($request);

        // Hanya track di public routes, skip admin routes dan halaman login/register
        if (
            !$request->is('admin') &&
            !$request->is('admin/*') &&
            !$request->is('login') &&
            !$request->is('register')
        ) {
            // Get portfolio owner (user pertama atau bisa dari settings)
            $owner = User::first();

            if ($owner) {
                $agent = new Agent();
                $ipAddress = $request->ip();

                // Cek apakah IP ini sudah visit hari ini
                $todayVisit = Visitor::where('ip_address', $ipAddress)
                    ->whereDate('created_at', today())
                    ->exists();

                // Catat hanya jika belum visit hari ini
                if (!$todayVisit) {
                    Visitor::create([
                        'user_id'      => $owner->id,
                        'ip_address'   => $ipAddress,
                        'user_agent'   => $request->userAgent(),
                        'device'       => $this->getDevice($agent),
                        'browser'      => $agent->browser(),
                        'os'           => $agent->platform(),
                        'referrer'     => $request->header('referer'),
                        'page_visited' => $request->path(),
                    ]);
                }
            }
        }

        // 🔥 WAJIB: kembalikan response agar tidak error
        return $response;
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
