<?php

namespace Void\Tokenizer;

use Void\Tokenizer\Builder\TokenBuilder;
use Void\Tokenizer\Contracts\TokenGenerator;
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

    /**
     * @param TokenBuilder $builder
     *
     * @return mixed
     */
    public function createToken(TokenBuilder $builder)
    {
        return $this->tokens()->create(array_merge(
            $builder->toArray(),
            ['token' => app(TokenGenerator::class)->generate()]
        ));
    }

    /**
     * @param TokenBuilder $builder
     * @param int          $number
     *
     * @return \Illuminate\Support\Collection
     */
    public function createTokens(TokenBuilder $builder, int $number)
    {
        $stack = [];
        for ($i = 1; $i < $number; $i++) {
            $stack[] = $this->createToken($builder);
        }

        return collect($stack);
    }
}
