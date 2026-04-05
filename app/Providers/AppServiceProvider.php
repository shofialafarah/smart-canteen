<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Paksa HTTPS di Production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 2. Fix untuk Vercel (Read-only filesystem)
        if (config('app.env') === 'production') {
            $viewPath = '/tmp/storage/framework/views';
            
            if (!is_dir($viewPath)) {
                mkdir($viewPath, 0755, true);
            }
            
            // Set path compile view secara dinamis saat runtime
            Config::set('view.compiled', $viewPath);
        }
    }
}