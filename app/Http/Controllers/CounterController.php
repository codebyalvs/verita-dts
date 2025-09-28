<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CounterController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $counter = Counter::firstOrCreate(['name' => 'default'], ['value' => 0]);
        return view('counter', ['counter' => $counter]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function increment()
    {
        $counter = Counter::firstOrCreate(['name' => 'default'], ['value' => 0]);

        // Use a transaction to ensure atomicity
        DB::transaction(function () use ($counter) {
            $counter->increment('value');
        });

        return redirect()->route('counter.show');
    }
}
