<?php

namespace App\Http\Controllers;

use App\IncomeType;
use Illuminate\Http\Request;
use App\Source;

class IncomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        return back()->with('success', "As receitas foram atribuídas a {$source->name}"); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IncomeType  $incomeType
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeType $incomeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncomeType  $incomeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomeType $incomeType)
    {
        $incomeType->update([
            'name' => $request->input("income-name"),
            'description' => $request->input("income-description"),
        ]);
        return back()->with('success', "A receita {$incomeType->name} foi atualizada");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IncomeType  $incomeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeType $incomeType)
    {
        // check if deleted records
        $name = $incomeType->name;
        $incomeType->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Tipo de receita apagado']);
        }

        return back()->with('success', "A receita {$name} foi apagada");
    }
}
