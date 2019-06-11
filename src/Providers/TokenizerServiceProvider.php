<?php

namespace Void\Tokenizer\Providers;

use Illuminate\Support\ServiceProvider;
use Void\Tokenizer\Contracts\TokenGenerator;
use Void\Tokenizer\Generators\LaravelGenerator;
use Void\Tokenizer\TokenizerService;

class TokenizerServiceProvider extends ServiceProvider
{
    /**
     * Register Tokenizer Service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tokenizer', function () {
            return new TokenizerService();
        });

        $this->app->bind(TokenGenerator::class, LaravelGenerator::class);

        \Void\Tokenizer\Facades\Tokenizer::forceDown();

        $this->mergeConfigFrom(__DIR__.'/../../config/tokenizer.php', 'tokenizer');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/tokenizer.php' => config_path('tokenizer.php'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'tokenizer');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
