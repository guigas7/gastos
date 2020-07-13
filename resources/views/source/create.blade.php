@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center center-vertical">
        <div class="card-body">
            <br>
            <div class="card">
                <div class="card-header">{{ __('Criar novo Centro') }}</div>
                    <div class="card-body">
                        <div class="cent">
                            <form method="POST" action="/centros/criar">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-5 col-form-label text-md-center">{{ __('Nome') }}</label>

                                    <div class="col-md-5">
                                        <input id="name" type="string" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <label for="slug" class="col-md-5 col-form-label text-md-center">{{ __('Link para acesso') }}</label>

                                    <div class="col-md-5">
                                        <input id="slug" type="string" class="form-control @error('slug') is-invalid @enderror" name="name" value="{{ old('description') }}" required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <label for="description" class="col-md-5 col-form-label text-md-center">{{ __('Descrição') }}</label>

                                    <div class="col-md-5">
                                        <input id="description" type="string" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row mb-0">
                                    <label for="income" class="col-md-5 col-form-label text-md-center">{{ __('Este centro também é um centro de Receita?') }}</label>

                                    <div class="col-md-2">
                                        <p>
                                            <input type="radio" id="vent-on" name="income" required value="1">
                                            <label for="income">Sim</label>
                                            <input type="radio" id="vent-off" name="income" value="0">
                                            <label for="income">Não</label>
                                        </p>
                                    </div>
                                </div>
                                <br>

                                <div class="form-group row mb-0">
                                    <button id="enviar" type="submit" class="btn btn-primary bt">
                                        {{ __('Enviar') }}
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
