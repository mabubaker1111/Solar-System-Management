<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Client\ServiceRequest;
use App\Observers\ServiceRequestObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        ServiceRequest::observe(ServiceRequestObserver::class);
    }
}
