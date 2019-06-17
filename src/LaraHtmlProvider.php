<?php

namespace LaraHtml;

use Illuminate\Support\ServiceProvider;
use LaraHtml\Console\LaraHtmlMakeCommand;

/**
 * Class LaraHtmlProvider
 * @package LaraHtml
 */
class LaraHtmlProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViewsFrom(__DIR__ . '/Templates', 'larahtml');

        if ($this->app->runningInConsole()) {
            $this->commands([
                LaraHtmlMakeCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/Config' => config_path('larahtml'),
        ], 'lhtmlcfg');

        $this->publishes([
            __DIR__ . '/Templates' => resource_path('views/vendor/larahtml'),
        ], 'lhtmltpl');

    }

}
