<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Movimento;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateConta;
use Illuminate\Support\Facades\DB;

class ContaController extends Controller
{
    public function index()
    {
        //$contas = Conta::where('user_id', $id)->paginate(5);

        $user = Auth::user();
        $qry = Conta::query();
        $qry = $qry->where('user_id', $user->id);
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

        return redirect()->route('contas', Auth::user()->id);
    }

    
}
