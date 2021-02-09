<?php

namespace App\Http\Controllers;

use App\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Source;
use App\Payday;
use Illuminate\Validation\Rule;

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
            $this->validateStore($request, $maxExpense, 0)->validate();

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
        $this->validateUpdate($request)->validate();

        if ($expenseType->fixed == 1 && $request->boolean("expense-type") == 0) {
            foreach ($expenseType->paydays as $payday) {
                $payday->delete();
            }
        }

        $expenseType->update([
            'name' => $request->input("name"),
            'fixed' => $request->boolean("expense-type"),
            'description' => $request->input("description"),
        ]);

        $savedPayDays = $expenseType->paydays;

        if ($request->has('due-days')) {
            $existingPayDays = $request->input('due-days');
            array_walk($existingPayDays, function(&$value, &$key) {
                $value = sprintf("%02d", intval($value));
            });
        } else {
            $existingPayDays = [];
        }
        // Handle existing due_days
        foreach ($savedPayDays as $index => $payday) {
            if (!in_array($payday->due_day, $existingPayDays)) {
                $payday->delete();
            }
        }
        $savedPayDays->fresh(); // If any were deleted,

        // Handle new due_days
        $possibleNewDays = $existingPayDays;
        if ($newPayDays = $request->has('due-days-new')) {
            $newPayDays = $request->input('due-days-new');
            array_walk($newPayDays, function(&$value, &$key) {
                $value = sprintf("%02d", intval($value));
            });
            $possibleNewDays = array_merge($existingPayDays, $newPayDays);
        }

        //dd($savedPayDays->pluck('due_day')->all());
        foreach ($possibleNewDays as $day) {
            if (!in_array($day, $savedPayDays->pluck('due_day')->all())) {
                // Get all ids from trashed paydays, indexed by their due_days
                $trashedDueDays = $expenseType->paydays()->onlyTrashed()->pluck('id', 'due_day')->all();
                // Finds the payday id by index, aka, by due_day
                if (in_array($day, array_keys($trashedDueDays))) {
                    // If exists, restore it
                    $newDay = Payday::onlyTrashed()->find($trashedDueDays[$day]);
                    $newDay->restore();
                } else {
                    $expenseType->paydays()->create(['due_day' => $day]);
                }
            }
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

    protected function validateStore(Request $request, $expAmnt, $incAmnt)
    {
        $rules = [
            'expense-names.*' => 'size:' . $expAmnt,
            'expense-descriptions.*' => 'size:' . $expAmnt,
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
        }
        return Validator::make($request->all(), $rules);
    }

    protected function validateUpdate(Request $request)
    {
        $rules = [
            'expense-type' => 'required|boolean',
            'name' => 'required|max:80',
            'description' => 'nullable|max:255',
        ];
        $existingPayDays = $request->input('due-days');
        $newPayDays = $request->input('due-days-new');
        if ($request->has('due-days')) {
            $rules['due-days.*'] = ['numeric', 'min:1', 'max:28', 'distinct', Rule::notIn($newPayDays)];
        }
        if ($request->has('due-days-new')) {
            $rules['due-days-new.*'] = ['numeric', 'min:1', 'max:28', 'distinct', Rule::notIn($existingPayDays)];
        }
        return Validator::make($request->all(), $rules);
    }
}
