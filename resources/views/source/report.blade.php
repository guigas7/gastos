@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> Relatórios </h1>

            Este centro não possui grupos de despesa, crie novos grupos <a href="{{ route('exgroup.index', $source->slug) }}">clicando aqui</a>!

        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/calendar.js') }}" defer></script>
@endsection
