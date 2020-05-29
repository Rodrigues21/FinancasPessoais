@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            
            </div>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Nome</th>
                        <th>Saldo</th>   
                        <th>Dono</th> 
                        <th>Acesso</th>                   
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partilhadas as $partilha)
                    <tr>                  
                        <td>{{$partilha->nome}}</td>
                        <td>{{$partilha->saldo_atual}}</td>
                        <td>{{$partilha->nome_dono}}</td>
                        <td>{{$partilha->pivot->so_leitura ? 'Leitura' : 'Completo' }}</td>
                        <td style="width:19%"> 
                            <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                <a  href="{{ route('contas.detalhes', $partilha->id) }}" title="Detalhes Conta" class="btn btn-primary" role="button" aria-pressed="true"><span class="fa fa-search"></span></a>
                            </div>  
                            
                                 
                        </td>
                       
                    
                    </tr>
                    @endforeach
        </tbody>
    </table>
    

</div>

@endsection