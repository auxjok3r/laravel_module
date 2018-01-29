<?php

namespace Icorebiz\ModuleName;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\View;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadMiddleware();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'base');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'base');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViews();
        $this->loadBreadcrumbs();
    }

    public function loadMiddleware(){
      return;
    }

    public function loadViews()
    {
        view()->composer('layouts.main_layout', function ($view) {
            View::make('base::header')->render();
            View::make('base::left_panel')->render();
            View::make('base::breadcrumb')->render();
            View::make('base::components_i18n')->render();
            View::make('base::main_script')->render();
        });

        view()->composer('base::left_panel', function ($view) {
            View::make('base::menu')->render();
        });
    }

    public function loadBreadcrumbs()
    {
        if (file_exists($file = __DIR__.'/routes/breadcrumbs.php'))
        {
            require_once $file;
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // TODO: MERGE CONFIG FILES https://laravel.com/docs/5.5/packages#resources
        // Register Helpers

        $this->mergeConfigFrom(
            __DIR__.'/config/enum.php', 'enum'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/report.php', 'report'
        );

        $this->mergeConfigFrom(
            __DIR__.'/config/features.php', 'features'
        );

        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once($filename);
        }
    }

}
