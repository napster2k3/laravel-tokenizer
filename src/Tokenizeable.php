<?php

namespace Void\Tokenizer;

use Void\Tokenizer\Models\Token;

trait Tokenizeable
{
    /**
     * Get all of the video's comments.
     */
    public function tokens()
    {
        return $this->morphMany(Token::class, 'tokenizeable');
    }
}