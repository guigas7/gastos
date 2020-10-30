<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Source;
use App\Month;
use App\ExpenseType;
use App\IncomeType;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
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
        //dd(compact('months', 'years'));
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
        $this->validateSource($request)->validate();
        $source = Source::create([
            'name' => $request->name,
            'income' => $request->boolean('income'),
        ]);

        // insert expenses
        if ($request->has('expense-names')) {
            $exNameAmnt = sizeof($request->input('expense-names'));
            $exDescAmnt = sizeof($request->input('expense-descriptions'));

            $maxExpense = min($exNameAmnt, $exDescAmnt);

            $expenses = collect();
            for ($i = 0; $i < $maxExpense; $i++) {
                $expenses->push(new ExpenseType([
                    'name' => $request->input('expense-names')[$i],
                    'fixed' => $request->boolean ('expense-type' . strval($i + 1)),
                    'description' => $request->input('expense-descriptions')[$i],
                ]));
            }

            $source->expenseTypes()->saveMany(array_values($expenses->all()));
        }

        // insert incomes
        if ($source->income == '1' && $request->has('income-names')) {
            $inNameAmnt = sizeof($request->input('income-names'));
            $inDescAmnt = sizeof($request->input('income-descriptions'));

            $maxincome = min($inNameAmnt, $inDescAmnt);

            $incomes = collect();
            for ($i = 0; $i < $maxincome; $i++) {
                $incomes->push(new IncomeType([
                    'name' => $request->input('income-names')[$i],
                    'description' => $request->input('income-descriptions')[$i],
                ]));
            }

            $source->incomeTypes()->saveMany(array_values($incomes->all()));
        }

        $request->session()->flash('success', "centro {$source->name} criado com sucesso");
        return redirect()->route('source.show', $source->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show(Source $source, Request $request)
    {
        $months = Month::all();
        $years = yearRange();
        $month = session('month', thisMonth());
        $year = session('year', thisYear());

        $source->createRecordsIfNotCreated($year);

        $incomeTypes = $source->incomesAt($year, $month);
        $fixedExpenseTypes = $source->expensesAt($year, $month, "all", "fixed");
        $variableExpenseTypes = $source->expensesAt($year, $month, "all", "variable");

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
        $validated = $this->validateSource($request)->validate();
        // Decided to take income out
        if ($source->income == 1 && $request->income == 0) {
            // If has existing incomes
            if ($source->incomeTypes->count() > 0) {
                $request->session()->flash('danger', "Apague as receitas existentes de {$source->name} antes de alterar o tipo do centro!");
                return back();
            }
        }
        $source->update($validated);

        $request->session()->flash('success', "Edição no centro {$source->name} feita com sucesso");
        return redirect()->route('source.show', $source->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source, Request $request)
    {
        if ($request->get('sure') != '1') {
            return back();
        }
        // delete 1 by one to activate model events of each type.
        foreach ($source->incomeTypes->merge($source->expenseTypes) as $type) {
            $type->delete();
        }
        foreach ($source->expenseGroups as $group) {
            $group->delete();
        }
        $source->delete();
        $request->session()->flash('success', "O centro {$source->name} foi apagado");
        return redirect()->route('source.index');
    }

    public function report(Source $source)
    {
        $groups = $source->expenseGroups;
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

    protected function validateSource(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'max:80'],
            'income' => ['required', 'boolean'],
        ]);
    }
}
