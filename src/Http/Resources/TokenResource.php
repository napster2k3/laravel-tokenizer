<?php

namespace Void\Tokenizer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'token'                     => $this->token,
            'is_active'                 => $this->isActive(),
            'require_user'              => $this->require_user,
            'user_id'                   => $this->user_id,
            'session_limit'             => $this->session_limit,
            'session_count'             => $this->session_count,
            'session_duration'          => $this->session_duration,
            'expired_at'                => $this->expired_at,
            'has_expired'               => $this->hasExpired(),
            'has_reached_session_limit' => $this->hasReachedSessionLimit(),
            'created_at'                => $this->created_at->format('M d Y - H:i:s'),
            'updated_at'                => $this->updated_at->format('M d Y - H:i:s'),
            'was_recently_created'      => $this->wasRecentlyCreated,
        ];
    }
}
