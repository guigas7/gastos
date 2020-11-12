<?php

namespace App\Http\Controllers;

use App\ExpenseType;
use Illuminate\Http\Request;
use App\Source;

class ExpenseTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Source $source)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Source $source, Request $request)
    {
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
        foreach (yearRange() as $year) {
            $source->createRecordsIfNotCreated($year);
        }
        return back()->with('success', "As despesas foram atribuídas a {$source->name}"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseType $expenseType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
        $expenseType->update([
            'name' => $request->input("name"),
            'fixed' => $request->boolean ("expense-type"),
            'description' => $request->input("description"),
        ]);
        return back()->with('success', "A despesa {$expenseType->name} foi atualizada");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
        $name = $expenseType->name;
        $expenseType->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Tipo de despesa apagado']);
        }

        return back()->with('success', "A despesa {$name} foi apagada"); 
    }


    public function record(Request $request, ExpenseType $expenseType)
    {
        $month = session('month', thisMonth());
        $year = session('year', thisYear());
        $record = $expenseType->records()->create([
            'value' => 0,
            'description' => null,
            'month_id' => $month->number,
            'year' => $year
        ]);

        if (request()->expectsJson()) {
            return response([
                'status' => 'Registro criado',
                'id' => $record->id
            ]);
        }

        return back()->with('success', "Um novo registro foi adicionado a despesa {$expenseType->name}.");
    }
}
