@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> Centros de Despesa </h1>
            <br>
            @foreach($centro as $key => $data)
                <tr>
                    <th>
                        <br>
                        <h4 style="text-align: center">
                            <a class="botao" href="{{ URL::to('despesa/' . $data->slug) }}">{{$data->name}}</a>
                        </h4>
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