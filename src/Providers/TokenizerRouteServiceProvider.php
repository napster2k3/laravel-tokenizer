<?php

namespace Void\Tokenizer\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Void\Tokenizer\Exception\TokenExpired;
use Void\Tokenizer\Exception\TokenSessionLimit;
use Void\Tokenizer\Models\Token;

class TokenizerRouteServiceProvider extends ServiceProvider
{
    /**
     * Register Tokenizer RouteBinding
     *
     * @return void
     */
    public function register()
    {
        foreach (config('tokenizer.tokenizeables') as $model) {
            \Route::bind(sprintf('tokenizer_%s', Str::camel(class_basename($model))), function ($value) use ($model) {
                $token = Token::where('token', $value)->where('tokenizeable_type', $model)->firstOrFail();

                // My original idea and codebase was to override laravel router to support conditional middleware injection.
                // I wanted to run the request throught middlewares if Tokenizer would detect a '/({tokenizer_(.*)})+/' route parameter.
                //
                // 1. Laravel Routing is not overridable:
                //    It can't be done properly since Laravel 5.
                //    Laravel/Illuminate/Routing/Router & Laravel/Illuminate/Routing/Route are direct php reference call.
                //    The only way was to override App\Http\Kernel (which isn't on package end..) and override dispatchToRouter.
                // 2. Listen Router Matched Event
                //    After event is dispatched, the route parameters are not resolved yet,
                //    I couldn't use the advantage from the route binding and would have to run queries twice..

                $this->expirationGuard($token)->userGuard($token)->sessionGuard($token);

                return $token;
            });
        }
    }

    /**
     * @param Token $token
     * @return $this
     * @throws TokenExpired
     */
    public function expirationGuard(Token $token)
    {
        if ($token->hasExpiration() && $token->hasExpired()) {
            throw new TokenExpired();
        }

        return $this;
    }

    /**
     * @param Token $token
     * @return $this
     * @throws TokenSessionLimit
     */
    public function sessionGuard(Token $token)
    {
        if ($token->hasLimitedSession()) {
            // Bypass guard if a current session is active
            if (Session::has($token->token) && Session::get($token->token)->isFuture()) {
                return $this;
            }

            $this->session_count += 1;

            // Verify session_limit has not been reached.
            if ($token->session_count > $token->session_limit) {
                throw new TokenSessionLimit(sprintf('Session limit reached for token: `%s`', $token->token));
            }

            Session::put($token->token, now()->addSeconds(config('tokernizer.session_time')));

            $token->save();
        }

        return $this;
    }

    /**
     * @param Token $token
     * @return $this
     */
    public function userGuard(Token $token)
    {
        if ($token->requireUser()) {
            if (!$user = Auth::user()) {
                redirect()->route('login');
            }

            abort_if($token->hasUserAttached() && $user->id !== $token->user_id, 403);

            if (!$token->hasUserAttached()) {
                $token->user_id = $user->id;
                $token->save();
            }
        }

        return $this;
    }
}