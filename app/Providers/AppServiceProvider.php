<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Actions\AllContacts;

use Illuminate\Support\ServiceProvider;
use BasementChat\Basement\Basement;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Basement::allContactsUsing(AllContacts::class);
    }
}
