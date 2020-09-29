@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
    <link rel="stylesheet" type="text/css" href="/css/exgroup.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="content w-75">
            <div class="cent mb-4">
                @if ($groups->first() == null)
                    {{ $source->name }} não possui nenhum grupo de despesa, crie novos grupos abaixo!
                @else
                    <h1> Grupos de despesa de {{ $source->name }} </h1>

                    @foreach ($groups as $group)
                        <h3>{$group->name}</h3>
                        <p>{{ $group->description }}</p>
                        <ul>
                            @foreach ($group->extypes as $extype)
                                <li>{{ $extype->name }}</li>
                            @endforeach
                        </ul>
                    @endforeach
                @endif
            </div>
            <div class="cent fixedw">
                <div class="card">
                    <div class="card-header col-form-label">
                        Criar novo grupo de despesa para {{ $source->name }}
                    </div>
        			<div class="card-body">
                        <div class="cent">
                            <form method="POST" action="{{ route('exgroup.store', $source->name) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-5 col-form-label text-md-center">Nome do grupo</label>

                                    <div class="col-md-5">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group mb-0">
                                    <div class="col-md-12 col-form-label text-md-center">
                                        <label class="cent bold mb-3">
                                            Selecione os tipos de despesas que fazem parte do grupo:
                                        </label>
                                        <ul class="checkboxes row">
                                        	@foreach ($extypes as $extype)
                                                <li class="col-md-4">
                                                    <label class="" for="{{ $extype->slug }}">
                                                        <input type="checkbox" name="extypes[]" id="{{ $extype->slug }}" value="{{ $extype->id  }}">
                                                        <span class="checkbox-custom"></span>
                                                        <span class="checkText">{{ $extype->name }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <hr>

                                <br>
                                <div class="form-group row mb-0">
                                    <button id="enviar" type="submit" class="cent btn btn-primary bt">
                                        Criar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/calendar.js') }}" defer></script>
@endsection
