<?php

namespace NickKh\Components;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load package views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nickkh');

        // Publish package views for overriding
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nickkh'),
        ], 'views');

        // Register Blade components automatically
        $componentsPath = __DIR__ . '/View/Components';
        if (is_dir($componentsPath)) {
            foreach (glob($componentsPath . '/*.php') as $file) {
                $className = 'NickKh\\Components\\View\\Components\\' . basename($file, '.php');
                if (class_exists($className)) {
                    Blade::component($className, strtolower(basename($file, '.php')), 'nickkh');
                }
            }
        }

        $this->publishes([
            __DIR__.'/../stubs/package.json' => base_path('package.json'),
        ], 'nickkh-packagejson');

    }

    public function register()
    {
        //
    }
}
