@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @foreach($me as $key => $ds)
            @if($ds->slug === $esp)
            <form method="POST" action="{{ route('/receitas/' . $ds->slug . '/editar') }}">
                
            </form>
            @endif
        @endforeach
        </div>
    </div>
</div>
@endsection