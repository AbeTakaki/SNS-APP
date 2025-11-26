<?php

namespace App\Http\Controllers\Xweet\Create;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : string
    {
        return 'Xweet作成画面';
    }
}
