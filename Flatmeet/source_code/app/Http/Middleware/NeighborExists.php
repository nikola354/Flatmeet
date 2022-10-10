<?php

namespace App\Http\Middleware;

use App\Models\Neighbor;
use Closure;
use Illuminate\Http\Request;

class NeighborExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $neighbor = Neighbor::where('email', auth()->user()->email)
            ->where('building_code', $request->segment(1))
            ->first();

        if($neighbor === null) return redirect()->back();
        if($neighbor->status !== 'accepted') return redirect()->back();

        return $next($request);
    }
}
