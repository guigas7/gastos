@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center">Centros de Despesa e Receita</h1>
            <br>

         

            @foreach($sources as $source)
                <tr>
                    <th>
                        <br>
                        @if($source->income == "1")
                        <h4 style="text-align: center">
                            <b>{{$source->name}}</b> <br><a class="botao" href="{{ route('source.show', $source->slug) }}">Despesa e Receita</a>
                        </h4>
                        @else
                        <h4 style="text-align: center">
                            <b>{{$source->name}}</b> <br><a class="botao" href="{{ route('source.show', $source->slug) }}">Despesa</a>
                        </h4>
                        @endif
                        <br>
                    </th>
                </tr>
            @endforeach
            <br>
            <h4 style="text-align: center">
                <a class="botao" href="{{ route('source.create') }}">{{ __('Criar novo centro') }}</a>
            </h4>
        </div>
    </div>
</div>
@endsection
