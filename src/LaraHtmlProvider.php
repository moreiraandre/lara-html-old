<?php

/**
 * Definições de comunicação com o Laravel.
 */

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
        /* Definindo que as Blades serão carregadas da pasta "Templates" do plugin ou do namespace "larahtml" se forem
         * exportadas.
         */
        $this->loadViewsFrom(__DIR__ . '/Templates', 'larahtml');

        // Definindo comando para criar arquivo de tela personalizada.
        if ($this->app->runningInConsole()) {
            $this->commands([
                LaraHtmlMakeCommand::class,
            ]);
        }

        // Definindo local para exportar configuração.
        $this->publishes([
            __DIR__ . '/Config' => config_path('larahtml'),
        ], 'lhtmlcfg');

        // Definindo local para exportar as Blades.
        $this->publishes([
            __DIR__ . '/Templates' => resource_path('views/vendor/larahtml'),
        ], 'lhtmltpl');
    }

}
