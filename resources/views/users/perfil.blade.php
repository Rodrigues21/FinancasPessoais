@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <p><form action="{{route('perfis')}}" method="GET">
                 <div class="input-group">
                    
                    <input name="name" placeholder="Nome" value="{{ old('name') }}">
                    <input name="email" placeholder="Email" value="{{ old('email') }}">
                    @if($user->adm)
                        <select class="custom-select" name="estado" id="estado">
                            <option value="empty">Escolher Bloqueado Ou Desbloqueado</option>
                            <option value="1">Bloqueado</option>
                            <option value="0">Desbloqueado</option>
                        </select>
                        <select class="custom-select" name="tipo" id="tipo" placeholder="Tipo">
                            <option value="empty">Escolher Administrador Ou Utilizador</option>
                            <option value="1">Administrador</option>
                            <option value="0">Utilizador</option>                	
                        </select>
                    @endif
                
                            
        
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div> 
                </div> 
            </form></p>

            
            
            
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Email</th>
                        @if($user->adm)
                            <th>Tipo</th>
                            <th>Bloqueado</th>
                            <th>Acções</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                    <tr>
                        <td>
                        @if($u->foto)
                            <img src="{{asset('storage/fotos/'.$u->foto)}}"  width="100"  style="max-width: 100%;  object-fit: cover"></td>
                        @else
                            <img src="storage/fotos/foto.png"  width="100" style="max-width: 100%; object-fit: cover">                        
                        @endif
                        <td>{{$u->name}}</td>
                        <td>{{$u->email}}</td>
                        @if($user->adm)
                            <td>{{$u->adm ? 'Administrador' : 'Utilizador'}}</th>
                            <td>{{$u->bloqueado ? 'Sim' : 'Não'}}</th>
                            <td>                                
                                <div class="col-sm-12">

                                    @if($user->id != $u->id)
                                    <form action="{{ route('perfis.block') }}" method="POST">
                                        @csrf
                                        <input name="block_user" type="hidden" value="{{$u->id}}">
                                        @if($u->bloqueado)
                                            <button type="submit" class="btn btn-primary btn-block">Desbloquear</button>
                                        @else
                                            <button type="submit" class="btn btn-danger btn-block">Bloquear</button>
                                        @endif
                                        
                                    </form> 
                                
                               

                                    <form action="{{ route('perfis.promote') }}" method="POST">
                                        @csrf
                                        <input name="block_promote" type="hidden" value="{{$u->id}}">
                                        @if($u->adm)
                                            <button type="submit" class="btn btn-danger btn-block">Despromover</button>
                                        @else
                                            <button type="submit" class="btn btn-primary btn-block">Promover</button>
                                        @endif
                                        
                                    </form> 
                                    @endif 
                                </div> 
                                    
                                    
                                
                            </td>
                        @endif
                    
                    </tr>
                    @endforeach
        </tbody>
    </table>
    {{ $users->withQueryString()->links() }}

</div>

@endsection