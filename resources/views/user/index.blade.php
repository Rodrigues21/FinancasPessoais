@extends('layouts.app')

@section('content')

<div class="col-lg-12 text-center">
    <div>
        @if ($user->foto)
            <img src="{{asset('storage/fotos/'.$user->foto)}}"  width="170" height="170" style="max-width: 100%;  border-radius: 50%; object-fit: cover">                        
        @else
            <img src="storage/fotos/foto.png" class="rounded" width="170" height="170" style="max-width: 100%; border-radius: 50%; object-fit: cover">                        
        @endif
    </div>
    <div>  
        <h1>{{$user->name}}</h1>
    </div>
    <div>
        <p><img src="storage/img/email.png"  width="35"  style="max-width: 100%; object-fit: cover">{{$user->email}}</img></p>
    </div>

    <div>
        @if ($user->NIF)
            <p><img src="storage/img/nif.png"  width="35"  style="max-width: 100%; object-fit: cover">{{$user->NIF}}</img></p>
        @endif
    </div>
    <div>
        @if ($user->telefone)
            <p><img src="storage/img/telefone.png"  width="35"  style="max-width: 100%; object-fit: cover">{{$user->telefone}}</img></p>
        @endif
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex flex-row" >
            <div class="column" style= "margin-right: 5px; margin-top: 5px;" >
                <a  href="{{ route('me.edit') }}" class="btn btn-primary" role="button" aria-pressed="true">Editar Perfil</a>                              
            </div>

            <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                <a  href="{{ route('me.edit.password') }}" class="btn btn-primary" role="button" aria-pressed="true" >Alterar Password</a>                                    
            </div>

            <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                <a  href="#" class="btn btn-danger" role="button" aria-pressed="true" >Apagar Conta</a>                                    
            </div>
        </div>
    </div>
</div>

@endsection