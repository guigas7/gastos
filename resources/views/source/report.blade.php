@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> Relatórios </h1>

            @if ($groups == null)
            	<p>
            		Este centro não possui grupos de despesa, crie novos grupos <a href="{{ route('exgroup.index', $source->slug) }}">clicando aqui</a>!
            	</p>
            @else
                <p>
                    Para alterar os grupos de despesas, <a href="{{ route('exgroup.index', $source->slug) }}">clique aqui</a>!
                </p>
            	<graph :values="[0, 200, 300]" :labels="['January', 'February', 'March']"></graph>
            @endif
        </div>
    </div>
</div>
@endsection
