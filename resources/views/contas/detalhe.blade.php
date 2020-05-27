@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <h1>{{$conta->nome}}</h1>
        <p>{{$conta->descricao}}</p>
        <p>Saldo Abertura: {{$conta->saldo_abertura}}€</p>
        <p>Saldo Atual: {{$conta->saldo_atual}}€</p>
            <div class="column" style= "margin-right: 5px;  margin-bottom: 5px;">                                
            <a  href="{{ route('movimento.create', $conta->id)}}" class="btn btn-success " title="Adicionar Movimento" role="button" aria-pressed="true" ><span class="fa fa-plus"></a>                                    
            </div>
            <p><form action="{{route('contas.detalhes', $conta->id)}}" method="GET">
                <div class="input-group">
                   
                   
                   <input type="date" name="data" class="form-control" id="data" placeholder="Data" value="{{ request()->input('data') }}">
                   <select name="tipo" id="inputType" class="form-control">
                        <option value="empty"> Escolha uma Opção </option>
                        <option value="D"  {{ request()->input('tipo') === 'D' ? 'selected' : '' }}>Despesa</option>
                        <option value="R"  {{ request()->input('tipo') === 'R' ? 'selected' : '' }}>Receita</option>
                    </select>

                    <select name="categoria_id" id="inputType" class="form-control">
                        <option  value="empty"> Escolha uma Opção </option>
                        @foreach ($categorias as $categoria):
                            <option value="{{$categoria->id}}" {{ request()->input('categoria_id') === $categoria->id ? 'selected' : ''}}>{{$categoria->nome}}</option>
 
                        @endforeach
                    </select>
                  
               
                           
       
                   <div class="input-group-append">
                       <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                   </div> 
               </div> 
           </form></p>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th>Data</th>
                        <th>Valor</th>                        
                        <th>Saldo Inicial</th>
                        <th>Saldo Final</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movimentos as $mov )
                        <tr>
                                                    
                        <td>{{$mov->data}}</td>
                            <td>{{$mov->valor}}</td>
                            <td>{{$mov->saldo_inicial}}</td>
                            <td>{{$mov->saldo_final}}</td>
                            <td>{{$mov->categoria->nome ?? ''}}</td>
                            <td>{{$mov->tipo == 'D' ? 'Despesa' : 'Receita'}}</td>
                            <td style="width:13.4%">  
                                <div class="btn-group" >            

                                    <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                
                                        <a  href="{{ route('movimento.edit', $mov) }}" title="Editar Movimento" class="btn btn-secondary" role="button" aria-pressed="true" ><span class="fa fa-pencil"></a>                                    
                                    </div>
    
                                    <div class="column" style= "margin-right: 5px;  margin-top: 5px;"> 
                                        <form action="{{ route('movimento.destroy', $mov) }}" method="POST">

                                            @csrf
                                            @method('delete')

                                            <button type="submit" title="Apagar Movimento" class="btn btn-danger"><span class="fa fa-trash-o"></span></a></button>                              
                                        </form> 
                                    </div> 

                                    @if($mov->descricao != null || $mov->imagem_doc != null)
                                        <div class="column" style= "margin-right: 5px;  margin-top: 5px;">                                     
                                        <button type="button" title="Detalhes do Movimento"class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-{{$mov->id}}">
                                            <span class="fa fa-search"></span>
                                        </button>
                                        </div>
                                    @endif

                                    <div class="modal fade" id="exampleModal-{{$mov->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Detalhes do Movimento</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{$mov->descricao}}</p>

                                                @if ( isset($mov->imagem_doc) )                            
                                                    <img src="{{route('movimentos.doc',$mov->id)}}">
                                                @endif
                                            </div>
                                            
                                          </div>
                                        </div>
                                      </div>
                                </div>    
                            </td>
                        
                        
                        </tr>
                        

                    @endforeach
        </tbody>
    </table>
    {{ $movimentos->withQueryString()->links() }}

</div>

@endsection