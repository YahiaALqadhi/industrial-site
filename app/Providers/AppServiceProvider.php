<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Inquiry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Share settings and new inquiries count globally
        View::composer('*', function ($view) {
            $settings = cache()->remember('site_settings', 3600, function () {
                return Setting::all()->pluck('value', 'key');
            });

            $newInquiriesCount = Inquiry::where('status', 'new')->count();

            $view->with('settings', $settings);
            $view->with('newInquiriesCount', $newInquiriesCount);
        });

        // Cache top categories for performance
        View::composer(['layouts.app', 'home'], function ($view) {
            $topCategories = cache()->remember('top_categories', 3600, function () {
                return \App\Models\Category::whereNull('parent_id')
                    ->where('is_active', true)
                    ->withCount('products')
                    ->orderBy('sort_order')
                    ->take(8)
                    ->get();
            });

            $view->with('topCategories', $topCategories);
        });
    }
}