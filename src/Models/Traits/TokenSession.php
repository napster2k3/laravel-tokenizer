<?php

namespace Void\Tokenizer\Models\Traits;


trait TokenSession
{
    /**
     * @return bool
     */
    public function hasLimitedSession()
    {
        return !is_null($this->session_limit);
    }

    /**
     * @return bool
     */
    public function hasReachedSessionLimit()
    {
        return $this->hasLimitedSession() && $this->session_count >= $this->session_limit;
    }

    /**
     * @return bool
     */
    public function revokeSessions()
    {
        $this->session_count = $this->session_limit;

        return $this->save();
    }
}