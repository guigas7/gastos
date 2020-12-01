@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
    <link rel="stylesheet" type="text/css" href="/css/report.css">
@endsection

@section('content')
    <div class="container-fluid text-center px-3">
        <div class="row d-flex justify-content-center">
            <div class="page-header col-lg-6 py-4">
                <a href="{{ route('source.despesas', $source->slug) }}" class="type-title">
                    <h1 class="mb-4">
                        {{ $source->name }}
                    </h1>
                </a>

                <x-calendar month="{{ $month->name }}" year="{{ $year }}"></x-calendar>
            </div>
        </div>
        <x-icons
        :receitas="false"
        :despesas="false"
        :report="false"
        :source="$source">
        </x-icons> 
    </div>


    @if ($groups == null)
        <div class="container">
            <div class="row justify-content-center">
                <div class="container-fluid text-center d.flex justify-content-center px-3 mb-2 row">
                    <h1> Relatórios</h1>
                	<p>
                		Este centro não possui grupos de despesa, crie novos grupos <a href="{{ route('exgroup.index', $source->slug) }}">clicando aqui</a>!
                	</p>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="container-fluid text-center d.flex justify-content-center px-3 mb-2 row">
                    <p>
                        Para alterar os grupos de despesas, <a href="{{ route('exgroup.index', $source->slug) }}">clique aqui</a>!
                    </p>
                </div>
            </div>
        </div>

        <div class="container-fluid text-center d.flex justify-content-center px-3 row" v-cloak>

            <div class="col-xl-5 mb-5">
                <div class="card">
                    <h4 class="card-header">
                        Geral - {{ $year }}
                    </h4>

                    <div class="card-body">
                        <div class="cent">
                            <ul class="list-group list-group-flush">
                                <anual-table
                                    :groups="{{ $groups }}"
                                    :attr1="'anualExpense'"
                                    :attr2="'monthlyAvg'"
                                    :attr3="'percentFromTotal'"
                                    :source="{{ $source }}"
                                    :colors="{{ App\Http\Utilities\Pallete::jsonValues($groups->count()) }}">
                                </anual-table>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 mb-5">
                <pie-chart
                    :groups="{{ $groups->pluck('name') }}"
                    :anual-sums="{{ $groups->pluck('anualExpense') }}"
                    :colors="{{ App\Http\Utilities\Pallete::jsonValues($groups->count()) }}">
                </pie-chart>
            </div>

            <div class="col-xl-5 mb-5">
                <div class="card">
                    <h4 class="card-header">
                        Despesas Fixas - {{ $year }}
                    </h4>

                    <div class="card-body">
                        <div class="cent">
                            <ul class="list-group list-group-flush">
                                <anual-table
                                    :groups="{{ $groups }}"
                                    :attr1="'anualFixedExpense'"
                                    :attr2="'monthlyFixedAvg'"
                                    :attr3="'fixedPercentFromTotal'"
                                    :source="{{ $source }}"
                                    :colors="{{ App\Http\Utilities\Pallete::jsonValues($groups->count()) }}">
                                </anual-table>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 mb-5">
                <pie-chart
                    :groups="{{ $groups->pluck('name') }}"
                    :anual-sums="{{ $groups->pluck('anualFixedExpense') }}"
                    :colors="{{ App\Http\Utilities\Pallete::jsonValues($groups->count()) }}">
                </pie-chart>
            </div>

            <div class="col-xl-5 mb-5">
                <div class="card">
                    <h4 class="card-header">
                        Despesas Variáveis - {{ $year }}
                    </h4>

                    <div class="card-body">
                        <div class="cent">
                            <ul class="list-group list-group-flush">
                                <anual-table
                                    :groups="{{ $groups }}"
                                    :attr1="'anualVariableExpense'"
                                    :attr2="'monthlyVariableAvg'"
                                    :attr3="'variablePercentFromTotal'"
                                    :source="{{ $source }}"
                                    :colors="{{ App\Http\Utilities\Pallete::jsonValues($groups->count()) }}">
                                </anual-table>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 mb-5">
                <pie-chart
                    :groups="{{ $groups->pluck('name') }}"
                    :anual-sums="{{ $groups->pluck('anualVariableExpense') }}"
                    :colors="{{ App\Http\Utilities\Pallete::jsonValues($groups->count()) }}">
                </pie-chart>
            </div>
        </div>
    @endif
@endsection
