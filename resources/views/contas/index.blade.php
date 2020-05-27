@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            <a  href="{{ route('contas.create')}}" class="btn btn-success " title="Adicionar Conta" role="button" aria-pressed="true" ><span class="fa fa-plus"></a>
            @if(!request()->apagadas)
                <a  href="{{ route('contas')}}?apagadas=1" class="btn btn-info " title="Mostrar Contas Eliminadas" role="button" aria-pressed="true" ><span class="fa fa-eye"></a>
            @else
                <a  href="{{ route('contas')}}" class="btn btn-info" role="button" title="Esconder Contas Eliminadas" aria-pressed="true" ><span class="fa fa-eye-slash"></a>
            @endif
            </div>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Nome</th>
                        <th>Saldo</th>   
                        <th>Estado</th>                     
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contas as $conta)
                    <tr>
                                                
                        <td>{{$conta->nome}}</td>
                        <td>{{$conta->saldo_atual}}</td>
                        <td>{{$conta->deleted_at == null ? 'Ativa' : 'Apagada'}}</td>
                        <td style="width:19%">  
                            
                            <div class="btn-group">

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="{{ route('contas.detalhes', $conta->id) }}" title="Detalhes Conta" class="btn btn-primary" role="button" aria-pressed="true"><span class="fa fa-search"></span></a>
                                </div> 

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="{{ route('contas.edit', $conta) }}" title="Editar Conta" class="btn btn-secondary" role="button" aria-pressed="true"><span class="fa fa-pencil"></span></a>
                                </div> 
                                                                
                                <span class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    @if($conta->deleted_at == null)
                                        <form class="form-inline" action="{{route('contas.delete', $conta->id)}}" method="GET">
                                            <button type="submit" title="Apagar Conta" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                        </form>
                                    @else
                                        <form class="form-inline pull-left" action="{{route('contas.activate', $conta->id)}}" method="GET">
                                            <button type="submit" title="Ativar Conta" style= "margin-right: 5px;" class="btn btn-success"><span class="fa fa-check"></span></a></button>                              
                                        </form>
                                        <form class="form-inline pull-left" action="{{route('contas.forcedelete', $conta->id)}}" method="GET">
                                            <button type="submit" title="Eliminar Permanentemente Conta" class="btn btn-danger"><span class="fa fa-ban"></span></a></button>                              
                                        </form>
                                    @endif 
                                </span> 
                            </div>    
                        </td>
                       
                    
                    </tr>
                    @endforeach
        </tbody>
    </table>
    {{ $contas->withQueryString()->links() }}

</div>

@endsection