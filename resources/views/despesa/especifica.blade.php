@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @foreach($sr as $key => $data)
                @if($data->slug === $pagina)
                    @foreach($ed as $key => $df)
                        @if($df->source_id === $data->id)
                            @if($df->year === '2019')
                                @if($df->month === '06')
                                    @foreach($me as $key => $ds)
                                        @if($ds->slug === $esp)
                                            @if($ds->id === $df->extype_id)
                                                <h1>{{$data->name}}</h1> 
                                                <br>
                                                <div class="row">
                                                    <div class="column">
                                                        <h1 style="text-align: left">
                                                            <a>{{$ds->name}}</a>
                                                        </h1>
                                                    </div>
                                                    <div class="column" >
                                                        <h4 style="text-align: right">
                                                            <a style="color:red"> - R$ {{ $df->value }} </a>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div style="text-align:center">
                                                    <br>
                                                    <h4>{{$ds->description}} </h4>
                                                    <br>
                                                    <br>
                                                    <h3>
                                                    <a class="botao" href="{{ URL::to('despesa/' . $data->slug . '/' . $ds->slug . '/editar') }}">Editar</a>
                                                    </h3>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endif
        @endforeach 
        </div>
    </div>
</div>
@endsection