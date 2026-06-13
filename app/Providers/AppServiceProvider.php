<?php

namespace App\Providers;

use App\Events\PostViewed;
use App\Listeners\IncrementPostViews;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind('test', function ($app) {
            return '';
        });
    }


    public function boot(): void
    {
        echo  $this->app->make('test');
        Event::Listen(
           PostViewed::class  , IncrementPostViews::class,
        );

    }
}
