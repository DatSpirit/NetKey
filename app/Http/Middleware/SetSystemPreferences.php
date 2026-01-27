<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSystemPreferences
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $preferences = $request->user()->preferences['display'] ?? [];

            // Set Locale
            if (isset($preferences['language'])) {
                app()->setLocale($preferences['language']);
            }

            // Set Timezone
            if (isset($preferences['timezone'])) {
                try {
                    config(['app.timezone' => $preferences['timezone']]);
                    date_default_timezone_set($preferences['timezone']);
                } catch (\Exception $e) {
                    // Fallback to default if invalid
                    config(['app.timezone' => 'UTC']);
                    date_default_timezone_set('UTC');
                }
            }

            // Share currency with all views
            view()->share('userCurrency', $preferences['currency'] ?? 'VND');
        }

        return $next($request);
    }
}
