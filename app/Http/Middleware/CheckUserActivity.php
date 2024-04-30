<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth; // Import the Auth facade  
class CheckUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
public function handle($request, Closure $next)
    {
        $maxInactiveMinutes = 5; // Set the maximum inactive time in minutes

        if (Auth::check()) {
            // Get the last activity time from the session
            $lastActivityTime = session('lastActivityTime', 0);

            // If the user has been inactive for longer than the allowed time, logout the user
            if (time() - $lastActivityTime > $maxInactiveMinutes * 60) {
                Auth::logout();
                $request->session()->flush(); // Clear all session data
                return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
            }
        }

        // Update the last activity time in the session
        $request->session()->put('lastActivityTime', time());

        return $next($request);
    }
}
