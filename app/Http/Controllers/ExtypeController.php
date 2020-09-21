<?php

namespace App\Http\Controllers;

use App\Extype;
use Illuminate\Http\Request;

class ExtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // List all expenses, with a list of all sources that have them in the selected date
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        $extypes = Extype::all();
        foreach ($extypes as &$extype) {
            $extype->sources = $extype->sources()->where([
                ["year", "2020"],
                ["month", "09"]
            ])->get()->toArray();
        }
        dd(compact('months', 'years', 'extypes'));
        return view('source.index', compact(
            'months', // all months, with name, short (name), and string
            'years', // all years, just strings
            'extypes', // all existing extypes
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Extype  $extype
     * @return \Illuminate\Http\Response
     */
    public function show(Extype $extype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Extype  $extype
     * @return \Illuminate\Http\Response
     */
    public function edit(Extype $extype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Extype  $extype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Extype $extype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Extype  $extype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Extype $extype)
    {
        //
    }
}
