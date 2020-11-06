<?php

namespace App\Http\Controllers;

use App\ExpenseGroup;
use Illuminate\Http\Request;
use App\Source;

class ExpenseGroupController extends Controller
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
            'description' => 'max:255',
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
        $request->session()->flash('success', "Grupo de despesa {$group->name} criado com sucesso");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseGroup $expenseGroup)
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
    public function update(Request $request, ExpenseGroup $expenseGroup)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:80',
            'description' => 'required|max:255',
            'expenseTypes.*' => 'exists:expense_types,id',
        ]);

        if ($request->has('expenseTypes')) {
            $types = collect(array_map(function ($id) {
                return \App\ExpenseType::find($id);
            }, $validatedData['expenseTypes']));

            $expenseGroup
                ->expenseTypes()
                ->saveMany(array_values($types->all()));
        }

        $expenseGroup->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $request->session()->flash('success', "Grupo de despesa {$expenseGroup->name} atualizado com sucesso");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseType  $expenseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ExpenseGroup $expenseGroup)
    {
        if ($request->get('sure') != '1') {
            return back();
        }
        $slug = $expenseGroup->source->slug;
        $name = $expenseGroup->name;
        $expenseGroup->delete();
        $request->session()->flash('success', "O grupo {$name} foi apagado");
        return redirect()->route('exgroup.index', $slug);
    }
}