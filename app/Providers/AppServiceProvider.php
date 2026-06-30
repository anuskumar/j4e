<?php

namespace App\Providers;

use App\Models\CompanySettings;
use App\Services\NotificationService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for older MySQL versions where utf8mb4 indexes are limited to 1000 bytes
        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        View::share('appLogoUrl', CompanySettings::appLogoUrl());
        View::share('companySettings', CompanySettings::current());

        View::composer('admin.layout.app', function ($view) {
            if (!Auth::check()) {
                return;
            }

            $notificationService = app(NotificationService::class);

            $view->with([
                'adminNotifications' => $notificationService->getUnreadForUser(Auth::user()),
                'adminNotificationCount' => $notificationService->getUnreadCount(Auth::user()),
            ]);
        });
    }
}
