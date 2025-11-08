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

        // Publish views (if you have views)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nickkh'),
        ], 'views');

        // Publish stubs (js/css/package.json)
        $this->publishes([
            __DIR__ . '/../stubs/js/components.js' => resource_path('js/components/components.js'),
            __DIR__ . '/../stubs/css/components.css' => resource_path('css/components/components.css'),
            __DIR__ . '/../stubs/package.json' => base_path('nickkh-package.json'),
        ], 'nickkh-assets');

        // Optionally register Blade components automatically (if you use classes)
        $componentsPath = __DIR__ . '/View/Components';
        if (is_dir($componentsPath)) {
            foreach (glob($componentsPath . '/*.php') as $file) {
                $className = 'NickKh\\Components\\View\\Components\\' . basename($file, '.php');
                if (class_exists($className)) {
                    // register component as <x-nickkh-{name}>
                    $alias = 'nickkh-' . strtolower(basename($file, '.php'));
                    Blade::component($className, $alias);
                }
            }
        }
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \NickKh\Components\Commands\MergePackageJson::class,
                \NickKh\Components\Commands\PostInstallSetup::class, // <--- new
            ]);
        }
    }
}
