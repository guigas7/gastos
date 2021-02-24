@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
    <link rel="stylesheet" type="text/css" href="/css/report.css">
@endsection

@section('content')
<div class="container larger-area">
    <div class="row justify-content-center">
        <div class="col-md-4 sidebar">
            <expense-selector
                :years="{{ json_encode($years) }}"
                :months="{{ json_encode($months) }}"
                :month="{{ $month }}"
                year="{{ $year }}"
                :source="{{ json_encode($source) }}">
            </expense-selector>
        </div>
        <div class="col-md-8">
            <selected-graph
                month="{{ $month->name }}"
                year="{{ $year }}"
                :source="{{ $source }}">
            </selected-graph>
        </div>
    </div>
</div>
@endsection