<?php

namespace Void\Tokenizer\Models;

use Illuminate\Database\Eloquent\Model;
use Void\Tokenizer\Facades\Tokenizer;
use Void\Tokenizer\Models\Traits\TokenExpires;
use Void\Tokenizer\Models\Traits\TokenSession;
use Void\Tokenizer\Models\Traits\TokenUser;

class Token extends Model
{
    use TokenExpires;
    use TokenSession;
    use TokenUser;

    /**
     * @var string
     */
    protected $table = 'tokenizer_tokens';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Tokenizer Forcedown.
     */
    public static function boot()
    {
        parent::boot();
        static::retrieved(function ($token) {
            if (Tokenizer::isForcedDown($token->tokenizeable)) {
                abort(404);
            }
        });
    }

    /**
     * The tokenizeable polymophic relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tokenizeable()
    {
        return $this->morphTo();
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return !$this->hasExpired() && !$this->hasReachedSessionLimit();
    }
}
