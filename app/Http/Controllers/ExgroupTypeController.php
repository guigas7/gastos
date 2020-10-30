<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseGroup;
use App\ExpenseType;
use App\Source;

class ExgroupTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Source $source, ExpenseGroup $exgroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
        $groupName = $expenseType->expenseGroup->name;
        $expenseType->expenseGroup()->dissociate()->save();
        return back()->with('success', "Despesa {$expenseType->name} foi retirada do grupo {$groupName}");
    }
}
