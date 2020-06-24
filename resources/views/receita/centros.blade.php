@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @foreach($sr as $key => $data)
            @if($data->slug === $pagina)
                <h1>{{$data->name}}</h1> 
                @foreach($ed as $key => $df)
                    @if($df->source_id === $data->id)
                        @if($df->year === '2019')
                            @if($df->month === '06')
                                @foreach($me as $key => $ds)
                                    @if($ds->id === $df->intype_id)
                                        <br>
                                        <h4 style="text-align: center">
                                            <a class="botao" href="{{ URL::to('despesa/' . $data->slug . '/' . $ds->slug) }}">{{$ds->name}}</a>
                                        </h4>
                                        <br>
                                        <p>{{$ds->description}}</p>
                                        <br>
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