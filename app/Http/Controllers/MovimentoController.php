<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Movimento;
use App\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateMovimento;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function movimentosConta(Request $request, $id){

       
        $conta = Conta::findOrFail($id);
        $user =  Auth::user();
        $tipo_acesso = 'completo';
        $autorizacao = DB::table('autorizacoes_contas')->where('conta_id', $id)->where('user_id', $user->id)->first();

        if($conta->user_id != $user->id && $autorizacao == null){
            return response(view('erros.autorizacao'), 403);
        }

        if($conta->user_id != $user->id){
            //conta partilhada
            if($autorizacao->so_leitura)
                $tipo_acesso = 'so_leitura';
        }

        $categorias = Categoria::all();
        $categoria_id = request('categoria_id');
        $tipo = request('tipo');
        $data = request('data');

        $qry = Movimento::query();

       //Filtrar dara
        if ($request->filled('data') ){
            $qry = $qry->withTrashed()->where('conta_id', $id)->where('data', $data)->orderByDesc('data')->orderByDesc('id');
        }

        if (isset($request->tipo) && $request->tipo != "empty"){
            $qry = $qry->withTrashed()->where('conta_id', $id)->where('tipo', $tipo)->orderByDesc('data')->orderByDesc('id');
        }

        if (isset($request->categoria_id) && $request->categoria_id != "empty"){
            $qry = $qry->withTrashed()->where('conta_id', $id)->where('categoria_id', $categoria_id)->orderByDesc('data')->orderByDesc('id');
        }

        $qry = $qry->withTrashed()->where('conta_id', $id)->orderByDesc('data')->orderByDesc('id');
        $movimentos = $qry->paginate(10);

        return view('contas.detalhe')->withMovimentos($movimentos)->withConta($conta)
        ->withCategorias($categorias)->withTipoacesso($tipo_acesso);
    }



    public function create($id){
        $conta = Conta::findOrFail($id);
        $user =  Auth::user();
        $autorizacao = DB::table('autorizacoes_contas')->where('conta_id', $id)->where('user_id', $user->id)->first();

        if($conta->user_id != $user->id && $autorizacao == null){
            return response(view('erros.autorizacao'), 403);
        }

        $categorias = Categoria::all();
        return view('movimentos.create')->withConta($conta)->withCategorias($categorias);
    }

    public function store(CreateMovimento $request, $id) {

        $conta = Conta::findOrFail($id);
        $user =  Auth::user();
        $autorizacao = DB::table('autorizacoes_contas')->where('conta_id', $id)->where('user_id', $user->id)->first();

        if($conta->user_id != $user->id && $autorizacao == null){
            return response(view('erros.autorizacao'), 403);
        }
        $request->ValidateCategory();
        $userInput = $request->validated();

        $movimento = new Movimento();
        $movimento->data=$userInput['data'];
        $movimento->valor=$userInput['valor'];
        $movimento->categoria_id=$userInput['categoria_id'];
        $movimento->tipo = $userInput['tipo'];
        $movimento->conta_id = $conta->id;
        $movimento->descricao = $userInput['descricao'] ?? null;

        if ($request->hasFile('imagem_doc')){
            $movimento->imagem_doc = basename($request->file('imagem_doc')->store('docs'));
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

        return redirect()->route('contas.detalhes', $conta->id)
        ->with('alert-msg', 'Movimento Criado Com Sucesso!')
        ->with('alert-type', 'success');
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

    public function destroy(Movimento $movimento)
    {
        $conta = Conta::findOrFail($movimento->conta_id);
        
        $user =  Auth::user();
        $autorizacao = DB::table('autorizacoes_contas')->where('conta_id', $id)->where('user_id', $user->id)->first();

        if($conta->user_id != $user->id && $autorizacao == null){
            return response(view('erros.autorizacao'), 403);
        }
        

        Storage::delete('docs/'. $movimento->imagem_doc);
        $data = $movimento->data;
        $movimento->delete();



        if (count($conta->movimentos()->where('data','<', $movimento->data)->get())>0){
            $saldo_final_mov_anterior = $conta->movimentos()->orderBy('data', 'desc')->orderByDesc('id')->where('data', '<=', $movimento->data)->first()->saldo_final;
        }else{
            $saldo_final_mov_anterior = $conta->saldo_abertura;
        }

        $movimentos_seguintes = $conta->movimentos()->where('data','>', $data)->orderBy('data')->orderBy('id')->get();
        foreach ($movimentos_seguintes as $movimento_seguinte){
            $movimento_seguinte->saldo_inicial =  $saldo_final_mov_anterior;
            if ($movimento_seguinte->tipo ="D"){
                $movimento_seguinte->saldo_final = $movimento_seguinte->saldo_inicial - $movimento_seguinte->valor;
            }else{
                $movimento_seguinte->saldo_final = $movimento_seguinte->saldo_inicial + $movimento_seguinte->valor;
            }
            $movimento_seguinte->save();
            $saldo_final_mov_anterior = $movimento_seguinte->saldo_final;
        }
        $conta->saldo_atual =  $saldo_final_mov_anterior;

        $ultimoMov = Movimento::where('conta_id', $conta->id)->orderBy('data')->orderBy('id')->get()->reverse(true)->first();

        $conta->data_ultimo_movimento = $ultimoMov->data ?? null;
        $conta->save();

        return redirect()->route('contas.detalhes', $conta->id)
        ->with('alert-msg', 'Movimento Eliminado Com Sucesso!')
        ->with('alert-type', 'success');

    }

    public function edit(Movimento $movimento){
        $conta = Conta::findOrFail($movimento->conta_id);
        
        $user =  Auth::user();
        $autorizacao = DB::table('autorizacoes_contas')->where('conta_id', $conta->id)->where('user_id', $user->id)->first();

        if($conta->user_id != $user->id && $autorizacao == null){
            return response(view('erros.autorizacao'), 403);
        }
        $categorias = Categoria::all();
        return view('movimentos.edit')->withMovimento($movimento)->withCategorias($categorias)->withConta($conta);
    }

    public function update(CreateMovimento $request, Movimento $movimento){
        $conta = Conta::findOrFail($movimento->conta_id);
        if($conta->user_id != Auth::user()->id){
            return response(view('erros.autorizacao'), 403);
        }
        $userInput = $request->validated();
        $movimento->data=$userInput['data'];
        $movimento->valor=$userInput['valor'];
        $movimento->categoria_id=$userInput['categoria_id'];
        $movimento->tipo = $userInput['tipo'];

        if ($movimento->tipo == "D"){
            $movimento->saldo_final = $movimento->saldo_inicial - $movimento->valor;
        }else{
            $movimento->saldo_final = $movimento->saldo_inicial + $movimento->valor;
        }

        $movimento->descricao = $userInput['descricao'] ?? null;

        if ($request->hasFile('imagem_doc') && $movimento->imagem_doc =! null){
            Storage::delete('docs/'. $movimento->imagem_doc);
            $movimento->imagem_doc = basename($request->file('imagem_doc')->store('docs'));
        }

        if (count($conta->movimentos()->where('data','<', $movimento->data)->get())>0){
            $saldo_final_mov_anterior = $conta->movimentos()->orderBy('data', 'desc')->orderByDesc('id')->where('data', '<=', $movimento->data)->where('id', '!=', $movimento->id)->first()->saldo_final;

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

        return redirect()->route('contas.detalhes', $conta->id)
        ->with('alert-msg', 'Movimento Editado Com Sucesso!')
        ->with('alert-type', 'success');
    }






}
