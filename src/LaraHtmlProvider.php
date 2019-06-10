<?php

/**
 * Ponto de partida para criação de telas
 */

namespace LaraHtml;

use Illuminate\Support\ServiceProvider;

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

        $this->publishes([
            __DIR__ . '/Templates' => resource_path('views/vendor/larahtml'),
        ]);

        $this->publishes([
            __DIR__ . '/config.php' => config_path('larahtml.php'),
        ]);

    }

}
