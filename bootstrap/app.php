<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\CheckAccountStatus::class,
            \App\Http\Middleware\SetSystemPreferences::class,
        ]);

        // Đăng ký alias cho middleware tuỳ chỉnh
        $middleware->alias([
            'admin'              => \App\Http\Middleware\AdminMiddleware::class,
            'check.account'      => \App\Http\Middleware\CheckAccountStatus::class,
            'require.admin.2fa'  => \App\Http\Middleware\RequireAdminTwoFactor::class,
        ]);

        // Middleware mặc định của API
        $middleware->api([
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Xử lý Rate Limiting - hiện thông báo thân thiện tiếng Việt
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
            $message = "Bạn thao tác quá nhanh. Vui lòng thử lại sau {$retryAfter} giây.";

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 429);
            }

            return back()->with('error', $message);
        });
    })
    ->create();