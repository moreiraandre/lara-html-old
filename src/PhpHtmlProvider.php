<?php

/**
 * Ponto de partida para criação de telas
 */

namespace PhpHtml;

use Illuminate\Support\ServiceProvider;

class PhpHtmlProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/path/to/views', 'courier');
    }

}
