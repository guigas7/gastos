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
                            <a href="{{ route('source.index') }}">{{$data->name}}</a>
                        </h4>
                        <br>
                    </th>
                </tr>
            @endforeach
            <h4 style="text-align: center">
                <a href="{{ route('source.create') }}">{{ __('Criar novo centro') }}</a>
            </h4>
        </div>
    </div>
</div>
@endsection