<?php

namespace Void\Tokenizer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class TokenizerService
{
    /**
     * @var bool
     */
    protected $forceDown = [];

    /**
     * @param mixed|null $model
     */
    public function forceDown($model = null)
    {
        if (!is_null($model) && is_array($model)) {
            $this->forceDown = array_merge($this->forceDown, $model);
        } else {
            $this->forceDown[] = $model ?: '*';
        }
    }

    /**
     * @return bool
     */
    public function isForcedDown($model)
    {
        return in_array(get_class($model), $this->forceDown) || in_array('*', $this->forceDown);
    }

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
            Route::patch('tokenizeable/{token}', 'Void\Tokenizer\Http\Controllers\TokenizerController@edit')->name('edit');
        });
    }
}