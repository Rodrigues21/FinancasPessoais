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
        $qry = $qry->where('conta_id', $id)->orderByDesc('data')->orderBy('id');
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

    public function store(CreateMovimento $request, Conta $conta) {

        $userInput = $request->validated();
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
