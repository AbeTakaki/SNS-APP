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
    public function __invoke(UpdateRequest $request) : RedirectResponse | abort
    {
        $userId = Auth::id();
        $xweet = Xweet::where('id', $request->getId())->firstOrFail();
        if ($userId === $xweet->user_id) {
            $xweet->content = $request->getXweet();
            $xweet->save();
            return redirect()->route('xweet.index');
        } else {
            abort(403);
        }
    }
}
