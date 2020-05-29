@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Editar Conta') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('contas.update', $conta) }}">
                        @csrf
                      
                        <div class="form-group row">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" required autocomplete="nome" autofocus value="{{ old('nome', $conta->nome) }}">

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descricao" class="col-md-4 col-form-label text-md-right">{{ __('Descrição') }}</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" autocomplete="descricao" autofocus value="{{ old('descricao', $conta->descricao) }}">

                                @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="saldo_abertura" class="col-md-4 col-form-label text-md-right">{{ __('Saldo Abertura') }}</label>

                            <div class="col-md-6">
                                <input id="saldo_abertura" type="text" class="form-control @error('saldo_abertura') is-invalid @enderror" name="saldo_abertura" autocomplete="saldo_abertura" autofocus value="{{ old('saldo_abertura', $conta->saldo_abertura) }}">

                                @error('saldo_abertura')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Editar') }}
                                </button>
                                <a class="btn btn-danger " href="{{route('contas')}}">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Adicionar Utilizadores</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contas.adicionar.user', $conta) }}">
                        @csrf                         

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control" id="email">
                        </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="so_leitura" value="1">
                            <label class="form-check-label" for="so_leitura">Só Leitura</label>
                          </div>
                          <button type="submit" class="btn btn-primary mb-2">Adicionar Utilizador</button>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Utilizadores Partilhados</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo Acesso</th>
                                    <th>Acções</th>
                                </thead>
                                <tbody>
                                    @foreach($conta->users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td><button type="button" onclick="setemail('{{$user->email}}')" class="btn btn-link">{{ $user->email }}</button></td>
                                        <td>{{ $user->pivot->so_leitura == 1 ? 'Leitura' : 'Completo' }}</td>
                                        <td>
                                            <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                                <form action="{{ route('conta.user.delete', [$conta->id, $user->id]) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" title="Apagar Relação Utilizador" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                                </form> 
                                            </div> 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function setemail(email){
        document.getElementById("email").value = email;
    }
</script>