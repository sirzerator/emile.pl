<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    public function register() {
    }

    public function boot(Dashboard $dashboard) {
        $dashboard->registerResource('stylesheets', '/custom.css');
    }
}
