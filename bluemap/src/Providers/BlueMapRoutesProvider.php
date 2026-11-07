<?php

namespace Hallo123wert\BlueMap\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class BlueMapRoutesProvider extends RouteServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware(['web', 'auth'])
                ->prefix('/bluemap')
                ->group(plugin_path('bluemap', 'routes/web.php'));
        });
    }
}
