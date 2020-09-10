@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> {{$source->name}} </h1>
            <br>

            <x-calendar value="{{ $month->name }} {{ $year }}"></x-calendar>

            <h4 style="text-align: center">Despesas</h4>
            @foreach($exregister as $key => $valor)
                @foreach($extypes as $key => $despesas)
                    @if($valor->extype_source == $despesas->id)
                        <h4> {{$despesas->name}} - {{$valor->value}} </h4>
                    @endif
                @endforeach
            @endforeach
            <br>
            <h4 style="text-align: center">Receitas</h4>
            @foreach($inregister as $key => $valor)
                @foreach($intypes as $key => $receitas)
                    @if($valor->intype_source == $receitas->id)
                        <h4> {{$receitas->name}} - {{$valor->value}} </h4>
                    @endif
                @endforeach
            @endforeach
        
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/calendar.js') }}" defer></script>
@endsection
