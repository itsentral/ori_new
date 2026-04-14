<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya track sekali per IP per hari
        $alreadyVisited = PageVisit::where('ip_address', $request->ip())
            ->whereDate('created_at', today())
            ->exists();

        if (!$alreadyVisited) {
            PageVisit::create([
                'ip_address' => $request->ip(),
                'user_id'    => auth()->id(),
            ]);
        }

        return $next($request);
    }
}