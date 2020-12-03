@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="row my-2 p-0 w-100 d-flex justify-content-center">
            @foreach ($sources as $source)
                <div class="col-lg-3 col-md-6 my-3">
                    <div class="row no-gutters border rounded flex-md-row mb-4 shadow-sm h-md-250 p-0 h-100">
                        <a href="{{ route('source.edit', $source->slug) }}" class="py-2 px-3 ml-auto">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-tools" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z"/>
                              <path fill-rule="evenodd" d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
                            </svg>
                        </a>
                        <div class="col-12 pb-0 px-4 pb-4 d-flex text-center flex-column">
                          <h3 class="mb-0">{{ $source->name }}</h3>
                          <a href="{{ route('source.report', $source->slug) }}" class="green">Relatórios e gráficos</a>
                        </div>
                        @if ($source->income)
                            <a href="{{ route('source.despesas', $source->slug) }}" class="p-3 col-6 d-flex justify-content-center link-box bg-orange">
                                Despesas
                            </a>
                            <a href="{{ route('source.receitas', $source->slug) }}" class="p-3 col-6 d-flex justify-content-center link-box bg-green">
                                Receitas
                            </a>
                        @else
                            <a href="{{ route('source.despesas', $source->slug) }}" class="p-3 col-12 d-flex justify-content-center link-box bg-orange">
                                Despesas
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
