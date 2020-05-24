@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Movimento') }}</div>

                <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('movimento.update', $movimento)}}">
                        @csrf
                      
                        <div class="form-group row">
                            <label for="data" class="col-md-4 col-form-label text-md-right">{{ __('Data') }}</label>
                            <div class="col-md-6">
                                <input type="date" name="data" class="form-control" id="data" placeholder="Data" value="{{ old('data', $movimento->data) }}">
                                @error('data')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="valor" class="col-md-4 col-form-label text-md-right">{{ __('Valor') }}</label>
                            <div class="col-md-6">
                                <input name="valor" id="valor" type="number" step="0.01" class="form-control{{ $errors->has('valor') ? ' is-invalid' : '' }}" value="{{ old('valor', $movimento->valor) }}">
                                @error('valor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
                            <div class="col-md-6">
                                    <select name="tipo" id="inputType" class="form-control">
                                        <option disabled selected> Escolha uma Opção </option>
                                        
                                        <option value="D" {{ $movimento->tipo == "D" ? 'selected' : '' }}>Despesa</option>
                                        <option value="R" {{ $movimento->tipo == "R" ? 'selected' : '' }}>Receita</option>
                                       
                                    </select>
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categoria_id" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                            <div class="col-md-6">
                                    <select name="categoria_id" id="inputType" class="form-control">
                                        <option  value="{{null}}"> Escolha uma Opção </option>
                                        @foreach ($categorias as $categoria):
                                            <option value="{{$categoria->id}}" {{ $movimento->categoria_id == $categoria->id ? 'selected' : '' }}>{{$categoria->nome}}</option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descricao" class="col-md-4 col-form-label text-md-right">{{ __('Descrição') }}</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" autocomplete="descricao" autofocus value="{{ old('descricao', $movimento->descricao) }}">

                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="imagem_doc" class="col-md-4 col-form-label text-md-right">{{ __('Documento') }}</label>
                            <p style="color:white">....</p>

                            <div class="col-md-5">
                                <input id="imagem_doc" type="file" class="form-control @error('imagem_doc') is-invalid @enderror" name="imagem_doc">
                                <label class="custom-file-label" for="imagem_doc">Escolha um Documento</label>

                                @error('imagem_doc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Criar') }}
                                </button>
                                <a class="btn btn-danger " href="{{route('contas.detalhes', $conta->id)}}">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection