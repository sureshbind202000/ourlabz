<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Contact;
use App\Models\PolicyPage;

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
        // if (app()->environment('local')) {
        //     Artisan::call('view:clear');
        //     Artisan::call('cache:clear');
        //     Artisan::call('config:clear');
        //     Artisan::call('route:clear');
        //     // URL::forceScheme('https');
        // }
        // view()->composer('*', function ($view) {
        //     $view->with('contactInfo', Contact::first())->with('policyPages', PolicyPage::where('status', 1)->get());;
        // });
        View::composer('*', function ($view) {
            // Cache for 1 hour (3600 seconds)
            $contactInfo = Cache::remember('contact_info', 3600, function () {
                return Contact::first();
            });

            $policyPages = Cache::remember('policy_pages', 3600, function () {
                return PolicyPage::where('status', 1)->get();
            });

            $view->with('contactInfo', $contactInfo)
                 ->with('policyPages', $policyPages);
        });

        // ✅ HTTPS force karna hai to uncomment karo (production ke liye)
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }
    }
}


