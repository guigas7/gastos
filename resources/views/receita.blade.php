@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> Centros de Receita </h1>
            <br>
            @foreach($centro as $key => $data)
                @if($data->income === 0)
                    <tr>
                        <th>
                            <br>
                            <h4 style="text-align: center">
                                <a class="botao" href="{{ route('source.index') }}">{{$data->name}}</a>
                            </h4>
                            <br>
                        </th>
                    </tr>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection