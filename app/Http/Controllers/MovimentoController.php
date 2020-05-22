<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Movimento;
use App\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateMovimento;

class MovimentoController extends Controller
{
    public function movimentosConta($id){
        
        $conta = DB::table('contas')->where('id', $id)->first();
        $qry = Movimento::query();
        $qry = $qry->where('conta_id', $id)->orderByDesc('data')->orderByDesc('id');
        $movimentos = $qry->paginate(10);
        
        return view('contas.detalhe')->withMovimentos($movimentos)->withConta($conta);
    }

    public function detalheMovimentos($id){
        $movimento = DB::table('movimentos')->where('id', $id)->first();
        
        return view('movimentos.detalhe')->withMovimento($movimento)->withUrl($url);
    }

    public function create($id){
        $conta = DB::table('contas')->where('id', $id)->first();
        $categorias = Categoria::all();
        return view('movimentos.create')->withConta($conta)->withCategorias($categorias);
    }

    public function store(CreateMovimento $request, $id) {
        
        $conta = Conta::findOrFail($id);
        $userInput = $request->validated();
        $movimento = new Movimento();
        $movimento->data=$userInput['data'];
        $movimento->valor=$userInput['valor'];
        $movimento->categoria_id=$userInput['categoria_id'];
        $movimento->tipo = $userInput['tipo'];
        $movimento->conta_id = $conta->id;

        if ($request->has('descricao')){
            $movimento->descricao = $userInput['descricao'];
        }


        if (count($conta->movimentos()->where('data','<', $movimento->data)->get())>0){
            $saldo_final_mov_anterior = $conta->movimentos()->orderBy('data', 'desc')->orderByDesc('id')->where('data', '<=', $movimento->data)->first()->saldo_final;
            
            $movimento->saldo_inicial = $saldo_final_mov_anterior; 
        }else{
            $movimento->saldo_inicial= $conta->saldo_abertura;
        }
        if ($movimento->tipo == "D"){
            $movimento->saldo_final = $movimento->saldo_inicial - $movimento->valor;
        }else{
            $movimento->saldo_final = $movimento->saldo_inicial + $movimento->valor;
        }

        $movimentos_seguintes = $conta->movimentos()->where('id', '!=', $movimento->id)->where('data','>', $movimento->data)->orderBy('data')->orderBy('id')->get();
        $ultimo_saldo_final = $movimento->saldo_final;
        foreach ($movimentos_seguintes as $movimento_seguinte){
            $movimento_seguinte->saldo_inicial = $ultimo_saldo_final;
            if ($movimento_seguinte->tipo == "D"){
                $movimento_seguinte->saldo_final = $movimento_seguinte->saldo_inicial - $movimento_seguinte->valor;
            }else{
                $movimento_seguinte->saldo_final = $movimento_seguinte->saldo_inicial + $movimento_seguinte->valor;
            }
            $ultimo_saldo_final= $movimento_seguinte->saldo_final;
            $movimento_seguinte->save();
        }

        $conta->saldo_atual = $ultimo_saldo_final;
        if ($conta->data_ultimo_movimento < $movimento->data){
            $conta->data_ultimo_movimento  = $movimento->data;
        }

        $conta->save();
        $movimento->save();

        return redirect()->route('contas.detalhes', $conta->id);
    }

    public function displayDoc($id)
    {
        $movimento = Movimento::findOrFail($id);
        if ( isset($movimento->imagem_doc) ) {
            return Storage::disk('local')->response("docs/" . $movimento->imagem_doc);
        }else{
            return response('Ficheiro não encontrado');
        }
    }

    


}
