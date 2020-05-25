@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            <a  href="{{ route('contas.create')}}" class="btn btn-success " role="button" aria-pressed="true" >Adicionar Conta</a>                                    
            </div>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Nome</th>
                        <th>Saldo</th>                        
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contas as $conta)
                    <tr>
                                                
                        <td>{{$conta->nome}}</td>
                        <td>{{$conta->saldo_atual}}</td>
                        <td style="width:13.4%">  
                            
                            <div class="btn-group">

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="{{ route('contas.detalhes', $conta->id) }}" class="btn btn-primary" role="button" aria-pressed="true"><span class="fa fa-search"></span></a>
                                </div> 

                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <a  href="{{ route('contas.edit', $conta) }}" class="btn btn-secondary" role="button" aria-pressed="true"><span class="fa fa-pencil"></span></a>
                                </div> 
                                                                
                                <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                    <form action="#" method="GET">
                                        <input name="id_conta" type="hidden" value="{{$conta->id}}">
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                    </form> 
                                </div> 
                            </div>    
                        </td>
                       
                    
                    </tr>
                    @endforeach
        </tbody>
    </table>
    {{ $contas->withQueryString()->links() }}

</div>

@endsection