<?php

namespace Void\Tokenizer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Void\Tokenizer\Contracts\TokenGenerator;
use Void\Tokenizer\Http\Resources\TokenResource;
use Void\Tokenizer\Models\Token;

class TokenizerController extends Controller
{
    /**
     * @param Request $request
     * @return TokenResource
     */
    public function list(Request $request)
    {
        $validated = $request->validate([
            'tokenizeable_type' => 'required',
        ]);

        return TokenResource::collection(Token::where('tokenizeable_type', $validated['tokenizeable_type'])->orderBy('id', 'desc')->simplePaginate(5)->appends(request()->input()));
    }

    /**
     * @param Request $request
     * @return TokenResource
     */
    public function create(Request $request, TokenGenerator $generator)
    {
        $validated = $request->validate([
            'session_limit' => 'nullable|integer',
            'session_duration' => 'nullable|integer',
            'expired_at' => 'nullable|date',
            'require_user' => 'required|boolean',
            'tokenizeable_type' => 'required',
            'tokenizeable_id' => 'required|integer'
        ]);

        return new TokenResource(Token::create(array_merge($validated, [
            'token' => $generator->generate()
        ])));
    }
}