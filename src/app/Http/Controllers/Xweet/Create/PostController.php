<?php

namespace App\Http\Controllers\Xweet\Create;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Xweet\CreateRequest;
use App\Models\Xweet;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request) : RedirectResponse
    {
        $xweet = new Xweet();
        $xweet->content = $request->getXweet();
        $xweet->user_id = $request->getUserId();
        $xweet->save();
        return redirect()->route('xweet.index');
    }
}
