<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Source;
use App\Month;
use App\ExpenseType;
use App\IncomeType;

class SourceController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $months = Month::all();
        $years = yearRange();
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        $sources = Source::all();
        return view('source.index', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'sources', // all sources
            'month', // current month, with name, short (name), and string
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
        dd(compact('months', 'years'));
        return view('source.create', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
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
        $months = Month::all();
        $years = yearRange();
        $month = session('month', thisMonth());
        $year = session('year', thisYear());

        $incomeTypes = $source->allIntypesAt($year, $month);
        $expenseTypes = $source->allExtypesAt($year, $month);
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

    public function report(Source $source)
    {
        $extypes = $source->extypesPeriod;
        $intypes = $source->intypesPeriod;
        $groups = $source->groups; 
        return view('source.report', compact(
            'source', // Current source
            'extypes', // All extypes from source
            'extypes', // All intypes from source
            'groups', // All groups from source
        ));

    }
}
