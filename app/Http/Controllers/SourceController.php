<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Source;
use App\Month;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $months = Month::all();
        $years = yearRange();
        $sources = Source::all();
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        // dd(compact('months', 'years', 'sources'));
        return view('source.index', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'sources', // all sources
            'month', // current month
            'year', // current year
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = Month::all();
        $years = yearRange();
        $extypes = Extype::all();
        $intypes = Intype::all();
        dd(compact('months', 'years', 'extypes', 'intypes'));
        return view('source.create', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'extypes', // all existing extypes
        	'intypes', // all existing intypes
        ));
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
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Source $source)
    {
        if (!$request->session()->has('month') || !$request->session()->has('year')) {
            session([
                'month' => thisMonth()->short,
                'year'  => thisYear(),
            ]);
        }
        $year = now()->format('Y');
        $months = Month::all();
        $years = yearRange();
        $intypes = $source->allIntypesAt($year, $month);
        $extypes = $source->allExtypesAt($year, $month);
        return view('source.show', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'month', // string of selected month
        	'year', // string of selected year
        	'extypes', // id, name, slug and description from extypes $source has in $year
        	'exregister', // all extype_sources, from all extypes $source has in $year, in $month
        	'intypes', // id, name, slug and description from intypes $source has in $year
        	'inregister', // all intype_sources, from all intypes $source has in $year, in $month 
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source)
    {
        $months = Month::all();
        $years = yearRange();
        $extypes = Extype::all();
        $intypes = Intype::all();
        dd(compact('months', 'years', 'extypes', 'intypes'));
        return view('source.edit', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'extypes', // all existing extypes
        	'intypes', // all existing intypes
        	'source', // current source to edit
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        //
    }
}
