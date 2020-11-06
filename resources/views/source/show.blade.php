@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
    <div class="container-fluid text-center px-3">
        <div class="row">
            <div class="page-header col-lg-6 offset-lg-3 py-4 mb-2">
                <h1 class="mb-3">{{$source->name}}</h1>

                <x-calendar month="{{ $month->name }}" year="{{ $year }}"></x-calendar>
            </div>
            <div class="page-header py-4 mb-2 col-lg-2 d-flex justify-content-center align-items-center">
                <a href="{{ route('source.report', $source->slug) }}">
                    <button type="button" class="btn btn-outline-primary">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <rect width="4" height="5" x="1" y="10" rx="1"></rect>
                            <rect width="4" height="9" x="6" y="6" rx="1"></rect>
                            <rect width="4" height="14" x="11" y="1" rx="1"></rect>
                        </svg>
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid text-center d.flex justify-content-center px-3 row" v-cloak>
        {{-- Despesas Fixas --}}
        <div class="col-xl-3 col-lg-6 mb-5">
            <div class="card">
                <h5 class="card-header">
                    Despesas Fixas de {{ $month->name }} - R${{ monthlySum($fixedExpenseTypes) }}
                </h5>

                <div class="card-body">
                    <div class="cent">
                        <ul class="list-group list-group-flush">
                            @foreach($fixedExpenseTypes as $expense)
                                <record
                                    :type-attrs="{{ $expense }}"
                                    :rec-attrs="{{ $expense->records->first()}}">
                                </record>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Despesas Variáveis --}}
        <div class="col-xl-3 col-lg-6 mb-5">
            <div class="card">
                <h5 class="card-header">
                    Despesas Variáveis de {{ $month->name }} - R${{ monthlySum($variableExpenseTypes) }}
                </h5>

                <div class="card-body">
                    <div class="cent">
                        <ul class="list-group list-group-flush">
                            @foreach($variableExpenseTypes as $expense)
                                <record
                                    :type-attrs="{{ $expense }}"
                                    :rec-attrs="{{ $expense->records->first()}}">
                                </record>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Receitas --}}
        @if ($source->income == true)
        <div class="col-xl-3 col-lg-6 mb-5">
            <div class="card">
                <h5 class="card-header">
                    Receitas de {{ $month->name }} - R${{ monthlySum($incomeTypes) }}
                </h5>

                <div class="card-body">
                    <div class="cent">
                        <ul class="list-group list-group-flush">
                            @foreach($incomeTypes as $income)
                                <record
                                    :type-attrs="{{ $income }}"
                                    :rec-attrs="{{ $income->records->first()}}">
                                </record>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Opções --}}
        <div class="col-xl-3 col-lg-6 mb-5">
            <b-card no-body class="card"  v-cloak>
                <b-tabs card justified>
                    {{-- Editar / Apagar --}}
                    <b-tab title="Ações" active>
                        <b-card-text>
                            <h3 class="text-center">Editar {{ $source->name }}</h3>
                            <form method="POST" action="{{ route('source.update', $source->slug) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group row py-3 justify-content-center">
                                    <label for="name" class="col-form-label">Nome</label>
                                    <div class="col-md-8">
                                        <input id="name"
                                            type="string"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name"
                                            value="{{ old('name') ? old('name') : $source->name }}"
                                            required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group pt-3 row d.flex justify-content-center">
                                    <label for="income" class="col-form-label col-md-8">Este centro também tem Receitas?</label>

                                    <div class="pl-1">
                                        <p>
                                            <input type="radio" id="with" name="income" required value="1" {{ $source->income ? 'checked' : '' }}>
                                            <label for="with">Sim</label>
                                        </p>
                                        <P>
                                            <input type="radio" id="without" name="income" value="0" {{ $source->income ? '' : 'checked' }}>
                                            <label for="without">Não</label>
                                        </P>
                                    </div>
                                </div>
                                <div class="form-group float-right mr-4 mb-4">
                                    <button id="atualizar-centro" type="submit" class="btn btn-primary bt">Atualizar</button>
                                </div>
                            </form>

                            <hr class="cb">

                            <h3 class="text-center">Apagar {{ $source->name }}</h3>
                            <form method="POST"
                                action="{{ route('source.delete', $source->slug) }}">
                                @csrf
                                @method('DELETE')
                                <div class="form-group pt-3 row d.flex justify-content-center">
                                    <label for="sure" class="col-form-label col-md-8">Deseja apagar esse centro e todos os tipos de despesa {{ $source->income == 1 ? 'e receita' : ''}} associados a ele?</label>

                                    <div class="pl-1">
                                        <p>
                                            <input type="radio" id="sure" name="sure" required value="1">
                                            <label for="sure">Sim</label>
                                        </p>
                                        <P>
                                            <input type="radio" id="notsure" name="sure" value="0" checked>
                                            <label for="notsure">Não</label>
                                        </P>
                                    </div>
                                </div>
                                <div class="form-group float-right mr-4">
                                    <button id="apagar-centro" type="submit" class="btn btn-danger btn-apagar ml-4 mb-2 align-middle">
                                        Apagar
                                    </button>
                                </div>
                            </form>
                        </b-card-text>
                    </b-tab>

                    @if ($source->income == true)
                    {{-- Adicionar Receitas --}}
                        <b-tab title="Criar receitas" v-cloak>
                            <form method="POST" action="{{ route('income.store', $source->slug) }}">
                                @csrf
                                <b-card-text>
                                    <insert-incomes>
                                    </insert-incomes>
                                </b-card-text>
                                <div class="form-group row float-right">
                                    <button id="criar-receita" type="submit" class="btn btn-primary bt">Criar receitas</button>
                                </div>
                            </form>
                        </b-tab>
                    @endif

                    {{-- Adicionar Despesas --}}
                    <b-tab title="Criar despesas" v-cloak>
                        <form method="POST" action="{{ route('expense.store', $source->slug) }}">
                            @csrf
                            <b-card-text>
                                <insert-expenses>
                                </insert-expenses>
                            </b-card-text>
                            <div class="form-group row float-right">
                                <button id="criar-despesa" type="submit" class="btn btn-primary bt">Criar despesas</button>
                            </div>
                        </form>
                    </b-tab>

                    {{-- Remover Despesas e Receitas --}}
                    <delete-lists
                        :has-income="{{ $source->income }}"
                        :fixed-list="{{ $fixedExpenseTypes }}"
                        :variable-list="{{ $variableExpenseTypes }}"
                        :income-list="{{ $incomeTypes }}">
                    </delete-lists>
                </b-tabs>
            </b-card>     
        </div>
    </div>
@endsection
