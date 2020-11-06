@extends('layouts.app')

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/source.css">
    <link rel="stylesheet" type="text/css" href="/css/exgroup.css">
@endsection

@section('content')
    <div class="container-fluid text-center d.flex justify-content-center px-3 row">

        @if ($groups->first() != null)
            <div class="col-xl-5 col-lg-5 mb-5">
                <div class="mb-4">
                    <h1 class="d-inline mr-3">Grupos de despesa de {{ $source->name }}</h1>
                    <a href="{{ route('source.report', $source->slug) }}">
                        <button type="button" class="btn btn-outline-primary">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <rect width="4" height="5" x="1" y="10" rx="1"></rect>
                                <rect width="4" height="9" x="6" y="6" rx="1"></rect>
                                <rect width="4" height="14" x="11" y="1" rx="1"></rect>
                            </svg>
                        </button>
                    </a>
                    <a href="{{ route('source.show', $source->slug) }}">
                        <button type="button" class="btn btn-outline-primary">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                              <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                              <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </button>
                    </a>
                </div>
 
                <b-card no-body class="card">
                    <b-tabs card justified>
                        {{-- Grupos existentes --}}
                        @foreach ($groups as $group)
                            <b-tab title="{{ $group->name }}">
                                <b-card-text>
                                    <p>{{ $group->description }}</p>

                                    <p class="d-inline">As despesas <b>fixas</b> estão marcadas com o ícone:</p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-lock-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z"/>
                                        <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                    </svg>

                                    <h3 class="my-4">Despesas:</h3>

                                    <div class="list-group">
                                        @foreach ($group->expenseTypes as $expenseType)
                                            <form method="POST"
                                                action="{{ route('exgroupType.delete', $expenseType->slug) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" class="list-group-item expense-list">
                                                    <h5 title="{{ $expenseType->description }}">{{ $expenseType->name }}</h5>
                                                    @if ($expenseType->fixed)
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-lock-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M2.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z"/>
                                                            <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                                        </svg>
                                                    @endif
                                                    <button id="enviar" type="submit" class="btn btn-danger btn-apagar btn-sm ml-4 mb-2 align-middle">
                                                        Remover
                                                    </button>
                                                </a>
                                            </form>
                                        @endforeach
                                    </div>
                                </b-card-text>
                                <b-card-text>
                                    <h2 class="text-center">Editar grupo {{ $group->name }}</h2>
                                    <form method="POST" action="{{ route('exgroup.update', $group->slug) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row py-3 d.flex justify-content-center">
                                            <label for="name" class="col-lg-4 col-form-label text-lg-center">Nome</label>
                                            <div class="col-md-7">
                                                <input id="name"
                                                    type="string"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name"
                                                    value="{{ old('name') ? old('name') : $group->name }}"
                                                    required autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-group pt-3 row d.flex justify-content-center">
                                            <label for="description" class="col-lg-4 col-form-label text-lg-center">Descrição do grupo</label>

                                            <div class="col-md-7">
                                                <textarea id="description"
                                                    name="description"
                                                    rows="4"
                                                    cols="50"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                >{{ old('description') ? old('description') : $group->description }}</textarea>

                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="col-lg-12 col-form-label text-lg-center">
                                                <label class="cent bold mb-3">
                                                    Marque para incluir tipos de despesas fixas:
                                                </label>
                                                <ul class="checkboxes row">
                                                    @foreach ($source->ungroupedExpenses("fixed") as $extype)
                                                        <li class="col-lg-4">
                                                            <label class="" for="{{ $group->slug }}{{ $extype->slug }}">
                                                                <input type="checkbox" name="expenseTypes[]" id="{{ $group->slug }}{{ $extype->slug }}" value="{{ $extype->id  }}">
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

                                        <div class="form-group mb-0">
                                            <div class="col-lg-12 col-form-label text-lg-center">
                                                <label class="cent bold mb-3">
                                                    Marque para incluir tipos de despesas variáveis:
                                                </label>
                                                <ul class="checkboxes row">
                                                    @foreach ($source->ungroupedExpenses("variable") as $extype)
                                                        <li class="col-lg-4">
                                                            <label class="" for="{{ $group->slug }}{{ $extype->slug }}">
                                                                <input type="checkbox" name="expenseTypes[]" id="{{ $group->slug }}{{ $extype->slug }}" value="{{ $extype->id  }}">
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

                                        <div class="form-group float-right mr-4 mb-4">
                                            <button id="enviar" type="submit" class="btn btn-primary bt">Atualizar</button>
                                        </div>

                                        <hr class="cb">
                                    </form>
                                </b-card-text>
                                <b-card-text>
                                    <h2 class="text-center">Apagar grupo {{ $group->name }}</h2>
                                    <form method="POST"
                                        action="{{ route('exgroup.delete', $group->slug) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="form-group pt-3 row d.flex justify-content-center">
                                            <label for="sure" class="col-form-label col-md-8">Deseja apagar esse grupo?</label>

                                            <div class="pl-1">
                                                <p>
                                                    <input type="radio" id="sure-{{ $group->slug }}" name="sure" required value="1">
                                                    <label for="sure-{{ $group->slug }}">Sim</label>
                                                </p>
                                                <P>
                                                    <input type="radio" id="notsure-{{ $group->slug }}" name="sure" value="0" checked>
                                                    <label for="notsure-{{ $group->slug }}">Não</label>
                                                </P>
                                            </div>
                                        </div>
                                        <div class="form-group float-right mr-4">
                                            <button id="enviar" type="submit" class="btn btn-danger btn-apagar ml-4 mb-2 align-middle">
                                                Apagar
                                            </button>
                                        </div>
                                    </form>
                                </b-card-text>
                            </b-tab>
                        @endforeach
                    </b-tabs>
                </b-card>  
            </div>
        @endif


        <div class="col-xl-6 col-lg-6 mb-5">
            <div class="card">
                <h4 class="card-header">
                    Criar novo grupo de despesas para {{ $source->name }}
                </h4>

                <div class="card-body">
                    <div class="cent">
                        <form method="POST" action="{{ route('exgroup.store', $source->slug) }}">
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
@endsection
