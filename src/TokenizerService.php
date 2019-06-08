<?php

namespace Void\Tokenizer;

use Illuminate\Database\Eloquent\Model;

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
}