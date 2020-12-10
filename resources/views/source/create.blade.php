@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
@endsection

@section('content')
<div class="container">
    <div class="justify-content-center">
        <h2 class="py-3 title">Criar novo Centro</h2>
    </div>
    <br><br>
    <form method="POST" action="{{ route('source.store') }}">
        @csrf
        <div class="form-group row py-3 justify-content-center">
            <label for="name" class="col-form-label">Nome</label>
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

        <div class="form-group pt-3 row justify-content-center">
            <label for="income" class="col-form-label">Este centro também tem Receitas?</label>

            <div class="pl-4">
                <p>
                    <input type="radio" id="with" name="income" value="1" {{ old('income') ? 'checked' : ''}}>
                    <label for="with">Sim</label>
                </p>
                <P>
                    <input type="radio" id="without" name="income" value="0" {{ old('income') === '0' ? 'checked' : ''}}>
                    <label for="without">Não</label>
                </p>
            </div>
        </div>
        <hr>

        <div class="mt-5 card col-lg-8 px-0">
            <b-card no-body>
                <b-tabs card justified>
                    <insert-expenses
                        @if (old('expense-names'))
                            :old="{{ json_encode(Session::getOldInput()) }}"
                        @endif
                            :active="true">
                    </insert-expenses>

                    <insert-incomes
                        @if (old('name'))
                            :old="{{ json_encode(Session::getOldInput()) }}">
                        @else
                            >
                        @endif
                    </insert-incomes>  
                </b-tabs>
            </b-card>     
        </div>

        <div class="form-group row float-right">
            <button id="enviar" type="submit" class="btn btn-primary bt">Enviar</button>
        </div>
    </form>
</div>
@endsection
