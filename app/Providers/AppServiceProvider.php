<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Setting;
use App\Observers\ActivityObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Global Settings Helper
        if (!function_exists('setting')) {
            function setting($key, $default = null)
            {
                try {
                    return Setting::getValue($key, $default);
                } catch (\Exception $e) {
                    return $default;
                }
            }
        }

        if (!function_exists('update_setting')) {
            function update_setting($key, $value)
            {
                try {
                    return Setting::setValue($key, $value);
                } catch (\Exception $e) {
                    return false;
                }
            }
        }
    }

    public function boot(): void
{
    Paginator::useBootstrapFive();

    // VIEW COMPOSER UNTUK SETTINGS
    View::composer('*', function ($view) {
        $view->with([
            'appName' => setting('app_name', 'Stockify'),
            'appLogo' => setting('app_logo'),
            'appFavicon' => setting('app_favicon'),
            'primaryColor' => setting('primary_color', '#3b82f6'),
            'companyName' => setting('company_name', 'Stockify'),
            'companyPhone' => setting('company_phone'),
            'companyEmail' => setting('company_email'),
            'companyAddress' => setting('company_address'),
        ]);
    });
}
}