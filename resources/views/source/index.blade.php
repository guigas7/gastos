@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> Centros do CEPETI </h1>
            <br>

            <!--<x-calendar value="{{ $month->name }} {{ $year }}"></x-calendar> --> 

            @foreach($sources as $source)
                <tr>
                    <th>
                        <br>
                        @if($source->income == "0")
                        <h4 style="text-align: center">
                            <b>{{$source->name}}</b> <br><a class="botao" href="{{ URL::to('centros/' . $source->slug) }}">Despesa e Receita</a>
                        </h4>
                        @else
                        <h4 style="text-align: center">
                            <b>{{$source->name}}</b> <br><a class="botao" href="{{ URL::to('despesa/' . $source->slug) }}">Despesa</a>
                        </h4>
                        @endif
                        <br>
                    </th>
                </tr>
            @endforeach
            <br>
            <h4 style="text-align: center">
                <a class="botao" href="{{ URL::to('/despesa/criar') }}">{{ __('Criar novo centro') }}</a>
            </h4>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/calendar.js') }}" defer></script>
@endsection
