@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
    <div class="container-fluid text-center px-3">
        <div class="row d-flex justify-content-center px-0">
            <div class="page-header col-lg-6 py-4 mb-2">
                <h1 class="mb-3">{{$source->name}}</h1>
            </div>
        </div>
        <x-icons
        :receitas="false"
        :despesas="false"
        :config="false"
        :source="$source">
        </x-icons> 
    </div>
    <div class="container-fluid text-center justify-content-center row mx-auto" v-cloak>
        {{-- Opções --}}
        <div class="col-xl-8 col-lg-12 mb-5">
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
                            
                            <delete-source
                            :attributes="{{ $source }}"
                            >

                            </delete-source>
                        </b-card-text>
                    </b-tab>

                    @if ($source->income == true)
                    {{-- Adicionar Receitas --}}
                        <b-tab title="Criar receitas" v-cloak>
                            <form method="POST" action="{{ route('income.store', $source->slug) }}">
                                @csrf
                                <b-card-text>
                                    <insert-incomes
                                    @if (old('income-names'))
                                        :old="{{ json_encode(Session::getOldInput()) }}">
                                    @else
                                        >
                                    @endif
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
                                <insert-expenses
                                    @if (old('expense-names'))
                                        :old="{{ json_encode(Session::getOldInput()) }}">
                                    @else
                                        >
                                    @endif
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
