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
        <div class="column"> 
        <div>
            <p><span class="fa fa-envelope-o" style= "margin-right: 5px"></span>{{$user->email}}</p>
        </div>

        <div>
            @if ($user->NIF)
                <p><span class="fa fa-id-card" style= "margin-right: 5px"></span>{{$user->NIF}}</p>               
            @endif
        </div>
        <div>
            @if ($user->telefone)
                <p><span class="fa fa-phone" style= "margin-right: 5px"></span>{{$user->telefone}}</p>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="d-flex flex-row" >
            <div class="column" style= "margin-right: 5px; margin-top: 5px;" >
                <a  href="{{ route('me.edit') }}" class="btn btn-primary" title="Editar Perfil" role="button" aria-pressed="true"><span class="fa fa-pencil"></a>                              
            </div>

            <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                <a  href="{{ route('me.edit.password') }}" class="btn btn-primary" title="Alterar Password" role="button" aria-pressed="true" ><span class="fa fa-key"></a>                                    
            </div>

            <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                <a  href="{{route('me.delete.view')}}" class="btn btn-danger" title = "Apagar Conta" role="button" aria-pressed="true" ><span class="fa fa-trash-o"></a>                                    
            </div>
        </div>
    </div>
</div>

@endsection
