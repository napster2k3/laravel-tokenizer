<?php

namespace Void\Tokenizer\Models;

use Illuminate\Database\Eloquent\Model;
use Void\Tokenizer\Contracts\TokenFactory;
use Void\Tokenizer\Models\Traits\HasExpiration;
use Void\Tokenizer\Models\Traits\HasLimitedSession;
use Void\Tokenizer\Models\Traits\HasUser;

class Token extends Model implements TokenFactory
{
    use HasUser;
    use HasExpiration;
    use HasLimitedSession;

    /**
     * @var string
     */
    protected $table = 'tokenizer_tokens';

    /**
     * The tokenizeable polymophic relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tokenizeable()
    {
        return $this->morphTo();
    }
}
