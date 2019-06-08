<?php

namespace Void\Tokenizer\Facades;

use Illuminate\Support\Facades\Facade;

class Tokenizer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tokenizer';
    }
}