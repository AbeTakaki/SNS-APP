<?php

namespace App\Http\Controllers\Xweet\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Xweet\UpdateRequest;
use App\Models\Xweet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request) : RedirectResponse
    {
        $xweet = Xweet::where('id', $request->getId())->firstOrFail();
        if(Auth::user()->cannot('update', $xweet)) abort(403);
        $xweet->content = $request->getXweet();
        $xweet->save();
        return redirect()->route('xweet.index');
    }
}
