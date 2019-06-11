<?php

namespace Void\Tokenizer\Contracts;

interface TokenGenerator
{
    /**
     * Generate the token.
     *
     * @param $length
     *
     * @return string
     */
    public function generate($length): string;
}
