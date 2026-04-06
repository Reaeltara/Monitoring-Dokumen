<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('documents:send-reminders')
            ->timezone(env('REMINDER_TZ', 'Asia/Jakarta'))
            ->dailyAt(env('REMINDER_TIME', '08:00'));
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'redirect.admin' => \App\Http\Middleware\RedirectAdminToAdminPage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();
