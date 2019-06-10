<?php

namespace Void\Tokenizer\Models\Traits;

use Carbon\Carbon;

trait TokenExpires
{
    /**
     * @return bool
     */
    public function hasExpiration()
    {
        return !is_null($this->expired_at);
    }

    /**
     * @return mixed
     */
    public function hasExpired()
    {
        return $this->hasExpiration() && $this->expired_at->isPast();
    }

    /**
     * @return bool
     */
    public function expiresNow()
    {
        $this->expired_at = now();

        return $this->save();
    }

    /**
     * @return \Carbon\CarbonInterface|static
     */
    public function getExpiredAtAttribute()
    {
        if (! is_null($this->attributes['expired_at'])) {
            return Carbon::parse($this->attributes['expired_at']);
        }
    }
}