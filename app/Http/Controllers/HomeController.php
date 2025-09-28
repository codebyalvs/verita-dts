<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $counter = Counter::firstOrCreate([], ['count' => 0]);
        return view('home', compact('counter'));
    }

    /**
     * Increment the counter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function increment(Request $request)
    {
        $counter = Counter::first();
        $counter->increment('count');

        if ($request->ajax()) {
            return response()->json(['count' => $counter->count]);
        }

        return redirect()->route('dashboard');
    }
}
