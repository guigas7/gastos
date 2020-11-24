@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="row my-2 p-0">
            @foreach ($sources as $source)
                <div class="col-lg-3 col-md-6 my-3">
                  <div class="row no-gutters border rounded flex-md-row mb-4 shadow-sm h-md-250 p-0 h-100">
                    <div class="col-12 pb-0 p-4 d-flex text-center flex-column">
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
