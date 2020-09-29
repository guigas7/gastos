<?php

namespace App\Http\Controllers;

use App\Exgroup;
use App\Source;
use Illuminate\Http\Request;

class ExgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Source $source)
    {
        $extypes = $source->extypesPeriod;
        $intypes = $source->intypesPeriod;
        $groups = $source->groups;
        return view('exgroup.index', compact(
            'source', // Current source
            'extypes', // All extypes from source
            'extypes', // All intypes from source
            'groups', // All groups from source
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Source $source, Request $request)
    {
        dd($request->extypes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exgroup  $exgroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Source $source, Exgroup $exgroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exgroup  $exgroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Source $source, Exgroup $exgroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exgroup  $exgroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source, Exgroup $exgroup)
    {
        //
    }
}
