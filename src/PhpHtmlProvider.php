<?php

/**
 * Ponto de partida para criação de telas
 */

namespace PhpHtml;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use PhpHtml\Finals\Row;

class PhpHtmlProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Template/bootstrap4', 'php-html');

        $this->publishes([
            __DIR__.'/Template' => resource_path('views/vendor/php-html'),
        ]);

        /*View::creator('profile', 'App\Http\View\Creators\ProfileCreator');

        View::composer('php-html', function ($view) {
            //
        });

        $this->app->singleton(PhpHtmlScreen::class, function ($app) {
            return new PhpHtmlScreen;
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
