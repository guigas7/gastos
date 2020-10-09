@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
    <link rel="stylesheet" type="text/css" href="/css/exgroup.css">
@endsection

@section('content')
    <div class="container-fluid text-center">
        <div class="py-5 text-center">
            @if ($groups->first() == null)
                {{ $source->name }} não possui nenhum grupo de despesa, crie novos grupos abaixo!
            @else
                <h1>  </h1>

                <div class="mt-5 card col-md-5">
                    <h4 class="card-header">
                        Grupos de despesa de {{ $source->name }}
                    </h4>

                    <div class="card-body">
                        <div class="cent">
                            @foreach ($groups as $group)
                                <hr>
                                <label class="cent bold">
                                    {{ $group->name }}
                                </label>
                                <hr>
                                
                                <p>{{ $group->description }}</p>
                                <ul>
                                    @foreach ($group->expenseTypes as $expenseType)
                                        <li>{{ $expenseType->name }}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
            <div class="cent row">
                <div class="card col-lg-5">
                    <h4 class="card-header">
                        Criar novo grupo de despesas fixas para {{ $source->name }}
                    </h4>

                    <div class="card-body">
                        <div class="cent">
                            <form method="POST" action="{{ route('exgroup.store', $source->name) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-lg-5 col-form-label text-lg-center">Nome do grupo</label>

                                    <div class="col-lg-5">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-5 col-form-label text-lg-center">Descrição do grupo</label>

                                    <div class="col-lg-5">
                                        <textarea id="description"
                                            name="description"
                                            rows="4"
                                            cols="50"
                                            class="form-control @error('description') is-invalid @enderror"
                                        >{{ old('description') }}</textarea>

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group mb-0">
                                    <div class="col-lg-12 col-form-label text-lg-center">
                                        <label class="cent bold mb-3">
                                            Selecione os tipos de despesas fixas que farão parte do grupo:
                                        </label>
                                        <ul class="checkboxes row">
                                            @foreach ($source->ungroupedExpenses("fixed") as $extype)
                                                <li class="col-lg-4">
                                                    <label class="" for="{{ $extype->slug }}">
                                                        <input type="checkbox" name="expenseTypes[]" id="{{ $extype->slug }}" value="{{ $extype->id  }}">
                                                        <span class="checkbox-custom"></span>
                                                        <span class="checkText">{{ $extype->name }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('expenseTypes[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <input type="hidden" name="fixed" value="1">

                                <br>
                                <div class="form-group mb-0">
                                    <button id="enviar" type="submit" class="cent btn btn-primary bt">
                                        Criar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card col-lg-5">
                    <h4 class="card-header">
                        Criar novo grupo de despesas variáveis para {{ $source->name }}
                    </h4>

                    <div class="card-body">
                        <div class="cent">
                            <form method="POST" action="{{ route('exgroup.store', $source->name) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-lg-5 col-form-label text-lg-center">Nome do grupo</label>

                                    <div class="col-lg-5">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <label for="description" class="col-lg-5 col-form-label text-lg-center">Descrição do grupo</label>

                                    <div class="col-lg-5">
                                        <textarea id="description"
                                            name="description"
                                            rows="4"
                                            cols="50"
                                            class="form-control @error('description') is-invalid @enderror"
                                        >{{ old('description') }}</textarea>

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <input type="hidden" name="fixed" value="0">

                                <div class="form-group mb-0">
                                    <div class="col-lg-12 col-form-label text-lg-center">
                                        <label class="cent bold mb-3">
                                            Selecione os tipos de despesas variáveis que farão parte do grupo:
                                        </label>
                                        <ul class="checkboxes row">
                                            @foreach ($source->ungroupedExpenses("variable") as $extype)
                                                <li class="col-lg-4">
                                                    <label class="" for="{{ $extype->slug }}">
                                                        <input type="checkbox" name="expenseTypes[]" id="{{ $extype->slug }}" value="{{ $extype->id  }}">
                                                        <span class="checkbox-custom"></span>
                                                        <span class="checkText">{{ $extype->name }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('expenseTypes[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <hr>

                                <br>
                                <div class="form-group mb-0">
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
