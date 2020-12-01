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
        <x-icons
        :dropdown="false"
        :despesas="false"
        :source="$source">
        </x-icons> 
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
