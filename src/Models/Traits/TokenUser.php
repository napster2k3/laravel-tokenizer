<?php

namespace Void\Tokenizer\Models\Traits;

use Illuminate\Contracts\Auth\Authenticatable as UserAuthenticatable;
use Void\Tokenizer\Facades\Tokenizer;

trait TokenUser
{
    /**
     * @return bool
     */
    public function requireUser(): bool
    {
        return $this->require_user;
    }

    /**
     * @return bool
     */
    public function hasUserAttached(): bool
    {
        return !is_null($this->user_id);
    }

    /**
     * @return bool
     */
    public function detachUser(): bool
    {
        $this->user_id = null;

        return $this->save();
    }

    /**
     * @param UserAuthenticatable $user
     *
     * @return bool
     */
    public function attachUser(UserAuthenticatable $user): bool
    {
        $this->user()->associate($user);

        return $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Tokenizer::userModel());
    }
}
