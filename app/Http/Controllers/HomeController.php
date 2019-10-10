<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Network;
use App\Container;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $networks = Network::where('user_id', $user->id)->get();
        $containers = Container::where('user_id', $user->id)->get();

        return view('home', compact('networks', 'containers'));
    }
}
