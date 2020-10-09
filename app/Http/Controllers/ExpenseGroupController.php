<?php

namespace App\Http\Controllers;

use App\ExpenseGroup;
use Illuminate\Http\Request;
use App\Source;

class ExpenseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Source $source)
    {
        $groups = $source->expenseGroupsWithExpenses;
        return view('exgroup.index', compact(
            'source', // Current source
            'groups', // Current groups of expenses from $source
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Source $source)
    {
        //dd($request);
        $validatedData = $request->validate([
            'name' => 'required|max:80',
            'description' => 'required|max:255',
            'fixed' => 'required|boolean',
            'expenseTypes' => 'required',
            'expenseTypes.*' => 'exists:expense_types,id',
        ]);
        $group = $source->ExpenseGroups()->create($request->except('expenseTypes'));
        
        $types = collect(array_map(function ($id) {
            return \App\ExpenseType::find($id);
        }, $validatedData['expenseTypes']));

        $group
            ->expenseTypes()
            ->saveMany(array_values($types->all()));
        return back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expenseType)
    {
        //
    }
}
