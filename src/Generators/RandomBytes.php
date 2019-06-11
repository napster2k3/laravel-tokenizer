<?php

namespace Void\Tokenizer\Generators;

use Void\Tokenizer\Contracts\TokenGenerator;

class RandomBytes implements TokenGenerator
{
    /**
     * @param $length
     *
     * @return string
     */
    public function generate($length = 10): string
    {
        return random_bytes($length);
    }
}
