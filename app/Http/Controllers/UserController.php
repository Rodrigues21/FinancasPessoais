<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AutorizacoesConta;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserPost;
use App\Http\Requests\UpdatePass;
use App\Http\Requests\ApagarConta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.index')->withUser($user);     
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit')->withUser($user);
    }

    public function update(UpdateUserPost $request)
    {
        $userInput = $request->validated();
        $user = Auth::user();
        $user->fill($userInput);
       

        if ($request->hasFile('foto')) {

            if ($user->foto != null) {
                Storage::delete('public/fotos/' . $user->foto);
            }

            $user->foto = basename($request->file('foto')->store('public/fotos'));
        }

        if (!$request->has('telefone')) {
            $user->telefone = null;
        }

        if (!$request->has('NIF')) {
            $user->NIF = null;
        }

        $user->save();
        return redirect()->route('me')
        ->with('alert-msg', 'Utilizador editado com sucesso!')
        ->with('alert-type', 'success');
   
    }

    public function editPassword()
    {
        $user = Auth::user();
        return view('user.editPassword')->withUser($user);
    }

    public function updatePassword(UpdatePass $request)
    {
        $request->validated();
        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect()->route('me')
                                ->with('alert-msg', 'Password alterada com sucesso!')
                                ->with('alert-type', 'success');;
    }

    public function perfis(Request $request)
    {

        $user = auth()->user();

        $qry = User::query();
        $estado = request('estado');
        $tipo = request('tipo');
            
        //Filtrar Nome
        if ($request->filled('name') ){
            $qry = $qry->where('name', 'LIKE', "%{$request->query('name')}%");
        }

        //Filtrar Email
        if ($request->filled('email')){
            $qry = $qry->where('email', 'LIKE', "%{$request->query('email')}%");
        }

        //Filtrar Tipo (Adminstrador/Utilizador)
        if (isset($request->tipo) && $request->tipo != "empty"){
            $qry = $qry->where('adm', $tipo);
        }

        //Filtrar Estado (Bloqueado/Desbloqueado)
        if (isset($request->estado) && $request->estado != "empty"){
            $qry = $qry->where('bloqueado', $estado);
        }

        $users = $qry->paginate(10);

        

        return view('users.perfil')->withUsers($users)->withUser($user);
    }

    public function manageblock(){

        $user_id = request('block_user');
        $user = User::find($user_id);
        
        if(Auth::user()->id != $user->id){
            $user->bloqueado = !$user->bloqueado;
            $user->save();
        }

        return redirect()->route('perfis');
    }


    public function managepromote(){

        $user_id = request('block_promote');
        
        $user = User::find($user_id);
        
        if(Auth::user()->id != $user->id){
            $user->adm = !$user->adm;
            $user->save();
        }

        return redirect()->route('perfis');
    }

    public function estatisticas(Request $request){
        $user = Auth::user();
        $contas = $user->contas()->get();
        $saldo_total=0;
        $total_receita=0;
        $total_despesa=0;

        foreach ($contas as $conta){
            $saldo_total += $conta->saldo_atual;
            $movimentos = $conta->movimentos()->get();

            foreach( $movimentos as $movimento){
                if ($request->filled('data1') && !$request->filled('data2')){
                    if($movimento->tipo == 'R' && $movimento->data == $request->data1 ){
                        $total_receita += $movimento->valor;
                        
                    }
                    if($movimento->tipo == 'D' && $movimento->data == $request->data1 ){
                        $total_despesa += $movimento->valor;
                    }
                }elseif(!$request->filled('data1') && $request->filled('data2')){
                    if($movimento->tipo == 'R' && $movimento->data == $request->data2 ){
                        $total_receita += $movimento->valor;
                        
                    }
                    if($movimento->tipo == 'D' && $movimento->data == $request->data2 ){
                        $total_despesa += $movimento->valor;
                    }

                }elseif($request->filled('data1') && $request->filled('data2')){
                    if($movimento->tipo == 'R' && $movimento->data >= $request->data1 && $movimento->data <= $request->data2){
                        $total_receita += $movimento->valor;
                        
                    }
                    if($movimento->tipo == 'D' && $movimento->data >= $request->data1 && $movimento->data <= $request->data2){
                        $total_despesa += $movimento->valor;
                    }

                }
                else{

                    if($movimento->tipo == 'R'){
                        $total_receita += $movimento->valor;
                    }else{
                        $total_despesa += $movimento->valor;
                    }

                }

                
                
                
            }
        }
        return view('user.estatisticas')->withSaldoTotal($saldo_total)->withContas($contas)
        ->withDespesaTotal($total_despesa)->withReceitaTotal($total_receita);
    }

    public function deleteview(){
        
        return view('user.apagar');

    }

    public function delete(ApagarConta $request){
        $userInput = $request->validated();
        $user = Auth::user();
        $autorizacoes= AutorizacoesConta::where('user_id', $user->id)->delete();
        

        /*foreach($autorizacoes as $autorizacao){
            
            $autorizacao->delete();
            dd($autorizacao);
        }*/

        $contas = $user->contas()->withTrashed()->get();

        foreach($contas as $conta){
            
            $autorizacoes= AutorizacoesConta::where('conta_id', $conta->id)->delete();
            
            
            
            $movimentos = $conta->movimentos()->withTrashed()->get();

            foreach($movimentos as $movimento){
                $movimento->forcedelete();
            }

            $conta->forcedelete(); 
            
        }
        
        

        $user->delete();

        return redirect()->route('home');
        

    }


}
