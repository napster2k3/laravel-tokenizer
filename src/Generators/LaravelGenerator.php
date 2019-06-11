<?php

namespace Void\Tokenizer\Generators;

use Illuminate\Support\Str;
use Void\Tokenizer\Contracts\TokenGenerator;

class LaravelGenerator implements TokenGenerator
{
    /**
     * @param $length
     *
     * @return string
     */
    public function generate($length = 10): string
    {
        return Str::random($length);
    }
}
