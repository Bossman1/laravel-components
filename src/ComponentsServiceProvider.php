<?php

namespace NickKh\Components;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load views namespace
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nickkh');

        // Publish views (optional)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nickkh'),
        ], 'views');

        // Publish stubs (js/css/package.json)
        $this->publishes([
            __DIR__ . '/../stubs/js/components.js' => resource_path('js/components/components.js'),
            __DIR__ . '/../stubs/css/components.css' => resource_path('css/components/components.css'),
            __DIR__ . '/../stubs/package.json' => base_path('nickkh-package.json'),
        ], 'nickkh-assets');

        // Automatically register all blade components in resources/views/components
        $componentsPath = __DIR__ . '/../resources/views/components';
        if (is_dir($componentsPath)) {
            foreach (glob($componentsPath . '/*.blade.php') as $file) {
                $name = strtolower(basename($file, '.blade.php'));
                Blade::component('nickkh::components.' . $name, $name);
                // <x-button> now works
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
