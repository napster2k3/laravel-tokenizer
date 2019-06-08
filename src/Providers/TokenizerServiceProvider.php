<?php

namespace Void\Tokenizer\Providers;

use Illuminate\Support\ServiceProvider;
use Void\Tokenizer\TokenizerService;

class TokenizerServiceProvider extends ServiceProvider
{
    /**
     * Register Tokenizer Service
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tokenizer', function () {
            return new TokenizerService();
        });

        $this->mergeConfigFrom(__DIR__ . '/../../config/tokenizer.php', 'tokenizer');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/tokenizer.php' => config_path('tokenizer.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}