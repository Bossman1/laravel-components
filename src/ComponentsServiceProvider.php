<?php

namespace NickKh\Components;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load views (adjust path if yours differs)
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nickkh');

        // Publish views (if you want users to override them)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nickkh'),
        ], 'views');

        // Publish stubs (js/css/package.json)
        $this->publishes([
            __DIR__ . '/../stubs/js/components.js' => resource_path('js/components/components.js'),
            __DIR__ . '/../stubs/css/components.css' => resource_path('css/components/components.css'),
            __DIR__ . '/../stubs/package.json' => base_path('nickkh-package.json'),
        ], 'nickkh-assets');

        // --- Option A: Register all Blade view components automatically ---
        $componentsPath = __DIR__ . '/../resources/views/components';
        if (is_dir($componentsPath)) {
            foreach (glob($componentsPath . '/*.blade.php') as $file) {
                $name = strtolower(basename($file, '.blade.php')); // e.g. 'button'
                Blade::component('nickkh::components.' . $name, $name);
                // Now <x-button> will work
            }
        }
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \NickKh\Components\Commands\MergePackageJson::class,
                \NickKh\Components\Commands\PostInstallSetup::class,
            ]);
        }
    }
}
