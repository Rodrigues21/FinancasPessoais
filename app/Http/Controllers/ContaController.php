<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Movimento;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateConta;
use App\Rules\EditarConta;

use Illuminate\Support\Facades\DB;

class ContaController extends Controller
{
    public function index()
    {
        //$contas = Conta::where('user_id', $id)->paginate(5);
        $user = Auth::user();
        $qry = Conta::query();
        if(request()->get('apagadas') == null){   

            $qry = $qry->where('user_id', $user->id);

        } else {

            $qry = $qry->withTrashed()->where('user_id', $user->id);
        }

        $contas = $qry->paginate(10);

        return view('contas.index')->withContas($contas);    
    }

    public function create() {
       return view('contas.create');
    }

    public function store(CreateConta $request) {

        $userInput = $request->validated();

        $conta = new Conta();
        $conta->fill($userInput);
        $conta->user_id = Auth::user()->id;
        $conta->saldo_atual=$conta->saldo_abertura;
        $conta->save();

        return redirect()->route('contas')
        ->with('alert-msg', 'Conta criada Com Sucesso!')
        ->with('alert-type', 'success');
    }

    public function edit(Request $request, Conta $conta){
        if($conta->user_id != Auth::user()->id){
            return response(view('erros.autorizacao'), 403);
        }

        return view('contas.edit')->withConta($conta);
    }

    public function update(Request $request, Conta $conta){
        
        if($conta->user_id != Auth::user()->id){
            return response(view('erros.autorizacao'), 403);
        }
        
        $userInput = $request->validate([
            'nome' => ['required',  new EditarConta($conta->id)],
            'saldo_abertura' => 'required|numeric',
            'descricao'=>'nullable|string',
        ]);

        
        $conta->nome = $userInput['nome'];
        $saldo_abertura_anterior = $conta->saldo_abertura;
        $conta->saldo_abertura = $userInput['saldo_abertura'];
        $conta->descricao = $userInput['descricao'] ?? null;

        if (is_null($conta->data_ultimo_movimento)) {
            $conta->saldo_atual = $userInput['saldo_abertura'];
        } else {
            
            $movimentos = Movimento::query()->where('conta_id', '=', $conta->id)->orderBy('data')->orderBy('id')->get();

            

            $movimento_saldo_final = $userInput['saldo_abertura'];
            foreach ($movimentos as $movimento) {
                $movimento->saldo_inicial = $movimento_saldo_final;
                
                if ($movimento->tipo== "D") {
                    $movimento->saldo_final = $movimento->saldo_inicial - $movimento->valor;
                } else {
                    $movimento->saldo_final = $movimento->saldo_inicial + $movimento->valor;
                }
                $movimento_saldo_final = $movimento->saldo_final;
                $movimento->save();

                $conta->saldo_atual = $movimento_saldo_final;
            }
        }

        $conta->save();


        return redirect()->route('contas')
        ->with('alert-msg', 'Conta Editada Com Sucesso!')
        ->with('alert-type', 'success');

    }

    public function delete($conta){

        $conta = Conta::find($conta);

        $conta->movimentos->each(function ($movimento, $key) {
            $movimento->delete();
        });
        
        $conta->delete();        

        return redirect()->route('contas')
        ->with('alert-msg', 'Conta eliminada Com Sucesso!')
        ->with('alert-type', 'success');

    }  
    
    public function forcedelete($conta){

        $conta = Conta::withTrashed()->find($conta);

        DB::table('movimentos')->where('conta_id',$conta->id)->delete();

        $conta->forcedelete();       

        return redirect()->route('contas')
        ->with('alert-msg', 'Conta eliminada Com Sucesso!')
        ->with('alert-type', 'success');

    }   

    public function activate($conta){
        
        $conta = Conta::withTrashed()->find($conta);
        $conta->deleted_at = null;
        $conta->save();

        DB::table('movimentos')->where('conta_id',$conta->id)->update(['deleted_at' => null]);

        return redirect()->route('contas')
        ->with('alert-msg', 'Conta ativada Com Sucesso!')
        ->with('alert-type', 'success');
    }

}
