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
            <div class="page-header pb-4 m-2" title="Receitas">
                <a href="{{ route('source.receitas', $source->slug) }}">
                    <button type="button" class="btn btn-outline-primary">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                          <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                          <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                          <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                </a>
            </div>
            <div class="page-header pb-4 m-2"  title="Relatórios">
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
    <div class="container-fluid text-center row mx-auto" v-cloak>
        {{-- Despesas Fixas --}}
        <div class="col-xl-6 col-lg-12 mb-5">
            <div class="card">
                <h5 class="card-header">
                    Despesas Fixas de {{ $month->name }} - R${{ monthlySum($fixedExpenseTypes) }}
                </h5>

                <type-list
                    :in-types="{{ $fixedExpenseTypes }}"
                    :base-url="{{ json_encode(url('/')) }}"
                    c-color="green">
                </type-list>
            </div>
        </div>
        
        {{-- Despesas Variáveis --}}
        <div class="col-xl-6 col-lg-12 mb-5">
            <div class="card">
                <h5 class="card-header orange">
                    Despesas Variáveis de {{ $month->name }} - R${{ monthlySum($variableExpenseTypes) }}
                </h5>

                <type-list
                    :in-types="{{ $variableExpenseTypes }}"
                    :base-url="{{ json_encode(url('/')) }}"
                    c-color="orange">
                </type-list>
            </div>
        </div>
@endsection
