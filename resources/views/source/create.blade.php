@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <br>
        <h2>{{ __('Criar novo Centro') }}</h2>
        <br>
    </div>
    <br><br>
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

        <div class="form-group row mb-0">
            <label for="income" class="col-md-5 col-form-label text-md-center">{{ __('Este centro também é um centro de Receita?') }}</label>

            <div class="col-md-2">
                <p>
                    <input type="radio" id="vent-on" name="income" required value="1">
                        <label for="income">Sim</label>
                        <br>
                    <input type="radio" id="vent-off" name="income" value="0">
                        <label for="income">Não</label>
                </p>
            </div>
        </div>
        <br>

        <div class="form_container">
            <button class="add_form_fields">Inserir novo tipo de despesa
                <span style="font-size:16px; font-weight:bold;">+ </span>
            </button>
        </div>
        <br><br>

        <div class="form_container_income">
            <button class="add_form_fields_income">Inserir novo tipo de receita
                <span style="font-size:16px; font-weight:bold;">+ </span>
            </button>
        </div>
        <br><br>
        
        <div class="form-group row mb-0">
            <button id="enviar" type="submit" class="btn btn-primary bt">
                {{ __('Enviar') }}
            </button>
        </div>

    </form>

</div>
@endsection
