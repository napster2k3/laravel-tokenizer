<?php

namespace Void\Tokenizer\Builder;

use Illuminate\Support\Carbon;
use Void\Tokenizer\Contracts\TokenGenerator;

class TokenBuilder
{
    /**
     * @var int
     */
    protected $sessionLimit;

    /**
     * @var int
     */
    protected $sessionDuration;

    /**
     * @var Carbon
     */
    protected $expiredAt;

    /**
     * @var bool
     */
    protected $requireUser = false;

    /**
     * @var TokenGenerator
     */
    protected $generator;

    /**
     * @param int      $max
     * @param int|null $duration
     *
     * @return $this
     */
    public function withSessions(int $max, int $duration = 3600)
    {
        $this->sessionLimit = $max;
        $this->sessionDuration = $duration;

        return $this;
    }

    /**
     * @return $this
     */
    public function requireUser()
    {
        $this->requireUser = true;

        return $this;
    }

    /**
     * @param Carbon $expiredAt
     *
     * @return $this
     */
    public function expiresOn(Carbon $expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'session_limit'    => $this->sessionLimit,
            'session_duration' => $this->sessionDuration,
            'require_user'     => $this->requireUser,
            'expired_at'       => $this->expiredAt,
        ];
    }
}
