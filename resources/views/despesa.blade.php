@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1> Centros de Despesa </h1>
            <br>
            <ul>
            @for ($i = $id; $i <= $last; $i++)

            @endfor
            </ul>
        </div>
    </div>
</div>
@endsection