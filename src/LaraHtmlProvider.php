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

        $this->loadViewsFrom(__DIR__ . '/Template/bootstrap4', 'larahtml');

        $this->publishes([
            __DIR__ . '/Template' => resource_path('views/vendor/larahtml'),
        ]);

        $this->app->alias(LaraHtmlScreen::class, 'larahtml');

        /*View::creator('profile', 'App\Http\View\Creators\ProfileCreator');

        View::composer('php-html', function ($view) {
            //
        });

        $this->app->singleton(LaraHtmlScreen::class, function ($app) {
            return new LaraHtmlScreen;
        });
        $this->app->singleton(Row::class, function ($app) {
            return new Row;
        });*/
        /*
        $this->publishes([
            __DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
        ]);
        */
    }

}
