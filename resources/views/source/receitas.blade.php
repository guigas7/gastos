@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
    <div class="container-fluid text-center px-3">
        <div class="row d-flex justify-content-center px-0">
            <div class="page-header col-lg-6 py-4 mb-2">
                @if ($source->income)
                <h1 class="mb-3">{{$source->name}}<span class="{{ $sum >= 0 ? 'text-success' : 'text-danger' }}">{{ '  R$' . $sum }}</span></h1>
                @else
                    <h1 class="mb-3">{{$source->name . '  R$' . $sum }}</h1>
                @endif

                <x-calendar month="{{ $month->name }}" year="{{ $year }}"></x-calendar>
            </div>
        </div>
        <div class="row px-0 d-flex justify-content-center">
            <div class="page-header pb-4 m-2" title="Despesas">
                <a href="{{ route('source.despesas', $source->slug) }}">
                    <button type="button" class="btn btn-outline-primary">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                          <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                          <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                </a>
            </div>
            <div class="page-header pb-4 m-2" title="Relatórios">
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
    <div class="container-fluid text-center justify-content-center row mx-auto" v-cloak>
        {{-- Receitas --}}
        @if ($source->income == true)
        <div class="col-xl-6 col-lg-12 mb-5">
            <div class="card">
                <h5 class="card-header">
                    Receitas de {{ $month->name }} - R${{ monthlySum($incomeTypes) }}
                </h5>

                <type-list
                    :in-types="{{ $incomeTypes }}"
                    :base-url="{{ json_encode(url('/')) }}"
                    c-color="dblue">
                </type-list>
            </div>
        </div>
        @endif

        {{-- Opções --}}
        <div class="col-xl-6 col-lg-12 mb-5">
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
                                            required>

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
