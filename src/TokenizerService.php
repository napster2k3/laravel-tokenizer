<?php

namespace Void\Tokenizer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class TokenizerService
{
    /**
     * Resolve User Model Through Laravel Auth User Provider
     *
     * @return Model
     */
    public function userModel(): Model
    {
        return config('auth.providers.users.model');
    }

    /**
     * Register Tokenizer Routes
     */
    public function routes()
    {
        Route::middleware(config('tokenizer.admin_middleware'))->name('tokenizer.')->prefix('tokenizer')->group(function () {
            Route::get('tokenizeable', 'Void\Tokenizer\Http\Controllers\TokenizerController@list')->name('list');
            Route::post('tokenizeable', 'Void\Tokenizer\Http\Controllers\TokenizerController@create')->name('create');
        });
    }
}