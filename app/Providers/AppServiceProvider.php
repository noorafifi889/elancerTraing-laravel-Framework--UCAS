<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('test',function ($app){
            return '';
        } );
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         echo  $this->app->make('test'); 
    }
}
