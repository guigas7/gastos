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
        $source = Source::first();
        return view('source.index', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'sources', // all sources
            'month', // Current month
            'year', // Current year
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
    public function show(Source $source)
    {
        $months = Month::all();
        $years = yearRange();
        $month = session('month', thisMonth());
        $year = session('year', thisYear());

        $source->createRecordsIfNotCreated($year);

        $incomeTypes = $source->incomesAt($year, $month);
        $fixedExpenseTypes = $source->expensesAt($year, $month, "all", "fixed");
        $variableExpenseTypes = $source->expensesAt($year, $month, "all", "variable");
        //dd($fixedExpenseTypes->first()->records);
        return view('source.show', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
        	'incomeTypes', // all income types from $source
            'fixedExpenseTypes', // all fixed expenseTypes from $source
        	'variableExpenseTypes', // all variabel expenseTypes from $source
            'source', // current source to show
            'month', // Current month
            'year', // Current year
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
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        $incomeTypes = $source->incomesAt($year, $month);
        $fixedExpenseTypes = $source->expensesAt($year, $month, "all", "fixed");
        $variableExpenseTypes = $source->expensesAt($year, $month, "all", "variable");
        dd(compact('months', 'years', 'incomeTypes', 'fixedExpenseTypes', 'variableExpenseTypes'));
        return view('source.edit', compact(
        	'months', // all months, with name, short (name), and string
        	'years', // all years, just strings
            'incomeTypes', // all income types from $source
            'fixedExpenseTypes', // all fixed expenseTypes from $source
            'variableExpenseTypes', // all variabel expenseTypes from $source
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
        $groups = $source->groups;
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        $fixedExpenseTypes = $source->expensesAt($year, $month, "all", "fixed");
        $variableExpenseTypes = $source->expensesAt($year, $month, "all", "variable");
        return view('source.report', compact(
            'fixedExpenseTypes', // all fixed expenseTypes from $source
            'variableExpenseTypes', // all variabel expenseTypes from $source
            'groups', // All groups from source
            'source', // Current source
            'month', // Current month
            'year', // Current year
        ));
    }
}
