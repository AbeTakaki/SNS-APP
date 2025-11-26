<?php

namespace App\Http\Controllers\Xweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('xweet.index', ['userName' => 'user1']);
    }
}
