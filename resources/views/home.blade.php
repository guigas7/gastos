@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bem-vindo</div>

                <div class="card-body">
                    Olá {{ Auth::user()->name }},
                    <br>
                    Este sistema foi criado com o intuito de facilitar a visualização e manutenção do fluxo de caixa do CEPETI.
                    <br>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
