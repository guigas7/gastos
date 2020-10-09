@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container-fluid text-center row px-3" id="app">
    <div class="page-header col-lg-6 offset-lg-3 py-4 mb-2">
        <h1 class="mb-3">{{$source->name}}</h1>

        <x-calendar month="{{ $month->name }}" year="{{ $year }}"></x-calendar>

    </div>

    <div class="card col-lg-5">
        <h4 class="card-header">
            Despesas Fixas
        </h4>

        <div class="card-body">
            <div class="cent">
                @foreach($fixedExpenseTypes as $expense)
                    <div class="form-group row">
                        <h5 class="col-lg-7 mb-2">
                            {{$expense->name}}
                        </h5>

                        <form method="POST"
                            action="{{ route('record.update', $expense->records->first()->id) }}"
                            class="col-lg-5 row fixed-height value-form">
                            @csrf
                            @method('PUT')
                            <input type="number"
                                id="mudarValor"
                                name="value"
                                step=".01"
                                class="mb-2 align-middle value-input"
                                value="{{ $expense->records->first()->value }}">
                            <button id="enviar" type="submit" class="btn btn-primary bt btn-salvar ml-4 mb-2 align-middle">
                                Salvar
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="card col-lg-5">
        <h4 class="card-header">
            Despesas Variáveis
        </h4>

        <div class="card-body">
            <div class="cent">
                @foreach($variableExpenseTypes as $expense)
                    <div class="form-group row">
                        <h5 class="col-lg-7 mb-2">
                            {{$expense->name}}
                        </h5>

                        <form method="POST"
                            action="{{ route('record.update', $expense->records->first()->id) }}"
                            class="col-lg-5 row fixed-height value-form">
                            @csrf
                            @method('PUT')
                            <input type="number"
                                id="mudarValor"
                                name="value"
                                step=".01"
                                class="mb-2 align-middle value-input"
                                value="{{ $expense->records->first()->value }}">
                            <button id="enviar" type="submit" class="btn btn-primary bt btn-salvar ml-4 mb-2 align-middle">
                                Salvar
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-5 card col-lg-5">
        <h4 class="card-header">
            Receitas
        </h4>

        <div class="card-body">
            <div class="cent">
                @foreach($incomeTypes as $income)
                    <div class="form-group row">
                        <h5 class="col-lg-7 mb-2">
                            {{$income->name}}
                        </h5>

                        <form method="POST"
                            action="{{ route('record.update', $income->records->first()->id) }}"
                            class="col-lg-5 row fixed-height value-form">
                            @csrf
                            @method('PUT')
                            <input type="number"
                                id="mudarValor"
                                name="value"
                                step=".01"
                                class="mb-2 align-middle value-input"
                                value="{{ $income->records->first()->value }}">
                            <button id="enviar" type="submit" class="btn btn-primary bt btn-salvar ml-4 mb-2 align-middle">
                                Salvar
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-5 card col-lg-5 px-0">
       <b-card no-body>
            <b-tabs card justified>
                <b-tab title="Editar {{ $source->limitedName30 }}" active>
                    <b-card-text>

                    </b-card-text>
                </b-tab>

                <b-tab title="Adicionar nova receita">
                    <b-card-text>

                    </b-card-text>
                </b-tab>

                <b-tab title="Adicionar nova despesa">
                    <b-card-text>

                    </b-card-text>
                </b-tab>

                <b-tab title="Remover despesas{{ $source->income == true ? ' e receitas' : '' }}">
                    <b-card-text>
                        <div class="cent">
                            <h4 class="card-header mb-4">Despesas fixas</h4>
                            @foreach($fixedExpenseTypes as $expense)
                                <div class="form-group row">
                                    <h5 class="col-lg-7 mb-2">
                                        {{$expense->name}}
                                    </h5>

                                    <form method="POST"
                                        action="{{ route('expense.delete', $expense->slug) }}"
                                        class="col-lg-5 row fixed-height value-form">
                                        @csrf
                                        @method('DELETE')
                                        <button id="enviar" type="submit" class="btn btn-danger btn-apagar ml-4 mb-2 align-middle">
                                            Apagar
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                            
                            <h4 class="card-header mb-4">Despesas variáveis</h4>
                            @foreach($variableExpenseTypes as $expense)
                                <div class="form-group row">
                                    <h5 class="col-lg-7 mb-2">
                                        {{$expense->name}}
                                    </h5>

                                    <form method="POST"
                                        action="{{ route('expense.delete', $expense->slug) }}"
                                        class="col-lg-5 row fixed-height value-form">
                                        @csrf
                                        @method('DELETE')
                                        <button id="enviar" type="submit" class="btn btn-danger btn-apagar ml-4 mb-2 align-middle">
                                            Apagar
                                        </button>
                                    </form>
                                </div>
                            @endforeach

                            <h4 class="card-header mb-4">Receitas</h4>
                            @foreach($incomeTypes as $income)
                                <div class="form-group row">
                                    <h5 class="col-lg-7 mb-2">
                                        {{$income->name}}
                                    </h5>

                                    <form method="POST"
                                        action="{{ route('income.delete', $income->slug) }}"
                                        class="col-lg-5 row fixed-height value-form">
                                        @csrf
                                        @method('DELETE')
                                        <button id="enviar" type="submit" class="btn btn-danger btn-apagar ml-4 mb-2 align-middle">
                                            Apagar
                                        </button>
                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </b-card-text>
                </b-tab>
            </b-tabs>
        </b-card>     
    </div>
</div>
@endsection
