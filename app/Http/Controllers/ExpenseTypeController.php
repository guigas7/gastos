<?php

namespace App\Http\Controllers;

use App\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Source;
use App\Payday;

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
            $this->validateArrays($request, $maxExpense, 0)->validate();

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

        foreach ($expenses as $key => $expense) {
            if ($request->has('due-day' . strval($key + 1))) {
                $paydays = [];
                foreach ($request->input('due-day' . strval($key + 1)) as $index => $value) {
                    $paydays[] = (['due_day' => strval($value)]);
                }
                $expense->paydays()->createMany($paydays);
            }
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
        //dd('testar o funcionamento de tudo, especialmente dos dias de pagamento');
        $expenseType->update([
            'name' => $request->input("name"),
            'fixed' => $request->boolean ("expense-type"),
            'description' => $request->input("description"),
        ]);

        $days = array_merge(
            $request->input('due-days')
                ? $request->input('due-days')
                : []
            , $request->input('due-days-new')
                ? $request->input('due-days-new')
                : []
        );
        // Difference = days to fill - existing paydays
        $difference = count($days) - $expenseType->Paydays->count();
        // if there are more due_days to fill than existing ones
        // dd($difference);
        if ($difference > 0) {
            for ($i = 0; $i < $difference; $i++) {
                $expenseType->paydays()->save(new Payday([
                    'due_day' => 1
                ]));
            }
        // if there are more existing than to fill
        } elseif ($difference < 0) {
            // soft delete exceding amount
            // foreach exceding payday
            foreach ($expenseType->Paydays->slice($difference + $expenseType->Paydays->count()) as $payday) {
                $payday->delete(); // soft deletes
            }
        }

        $expenseType->refresh();

        foreach ($expenseType->Paydays as $key => $value) {
            $value->due_day = sprintf("%02d", $days[$key]);
            $value->save();
        }

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

    protected function validateArrays(Request $request, $expAmnt, $incAmnt)
    {
        $rules = [
            'expense-names.*' => ['size:' . $expAmnt],
            'expense-descriptions.*' => ['size:' . $expAmnt],
        ];
        for ($i = 0; $i < $expAmnt; $i++) {
            $rules['expense-type' . ($i + 1)] = 'required|boolean';
            $rules['expense-names.' . $i] = 'required|max:80';
            $rules['expense-descriptions.' . $i] = 'nullable|max:255|nullable';
            if ($request->has('due-days')) {
                $payDaysAmnt = sizeof($request->input('due-days' . ($i + 1)));
                for ($j = 0; $j <= $payDaysAmnt; $j++) {
                    $rules['due-days.' . $j] = 'numeric|min:1|max:28';
                }
            }
            if ($request->has('due-days-new')) {
                $payDaysAmnt = sizeof($request->input('due-days-new' . ($i + 1)));
                for ($j = 0; $j <= $payDaysAmnt; $j++) {
                    $rules['due-days.' . $j] = 'numeric|min:1|max:28';
                }
            }
        }
        return Validator::make($request->all(), $rules);
    }
}
