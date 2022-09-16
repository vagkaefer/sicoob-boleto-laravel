<?php

namespace VagKaefer\Sicoob;

use Illuminate\Support\ServiceProvider;
use VagKaefer\Sicoob\Console\UpdateBoletosStatusCommand;

class BoletoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('boleto', function ($app) {
            return new Boleto();
        });

        $this->mergeConfigFrom(__DIR__ . '/config/sicoob-boleto.php', 'sicoob-boleto');
    }

    public function boot()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {

            $this->commands([
                UpdateBoletosStatusCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/config/sicoob-boleto.php' => config_path('sicoob-boleto.php'),
            ], 'config');
        }

        // Import routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
