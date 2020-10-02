@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1>{{$source->name}}</h1>
    </div>

    <x-calendar value="{{ $month->name }} {{ $year }}"></x-calendar>


    <div class="panel panel-default col-sm-4">
        <div class="panel-heading">
            <h3 class="panel-title">Despesas Fixas</h3>
        </div>
        <div class="panel-body">
            @foreach($source->fixedExpenses as $expense)
                @foreach($extypes as $key => $despesas)
                    @if($valor->extype_source == $despesas->id)
                        <h4> {{$despesas->name}} - 
                            Valor: <input type="text" id="mudarValor" value="{{$valor->value}}">
                        </h4>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
    <h4 style="text-align: center">Receitas</h4>
    @foreach($inregister as $key => $valor)
        @foreach($intypes as $key => $receitas)
            @if($valor->intype_source == $receitas->id)
                <h4> {{$receitas->name}} - {{$valor->value}} </h4>
            @endif
        @endforeach
    @endforeach
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/calendar.js') }}" defer></script>
    <script>
        function MudarValor() {
            var x = document.getElementById("mudarValor").value;
        }
    </script>
@endsection
