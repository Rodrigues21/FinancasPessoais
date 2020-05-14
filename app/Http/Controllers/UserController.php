<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserPost;
use App\Http\Requests\UpdatePass;
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
        return redirect()->route('me');
   
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
        return redirect()->route('me');
    }

    public function perfis(Request $request)
    {

        $user = auth()->user();

        $qry = User::query();
        $estado = request('estado');
        $tipo = request('tipo');

        $cena= $request->input('estado');
        
        
       //Filtrar Nome
        if ($request->filled('name') && !$request->filled('email') && (request('tipo') == "empty") && (request('estado') == "empty")){
            $qry = $qry->where('name', 'LIKE', "%{$request->query('name')}%");
        }

        //Filtrar Email
        if (!$request->filled('name') && $request->filled('email') && (request('tipo') == "empty") && (request('estado') == "empty")){
            $qry = $qry->where('email', 'LIKE', "%{$request->query('email')}%");
        }

        //Filtrar Tipo (Adminstrador/Utilizador)
        if (!$request->filled('name') && !$request->filled('email')  && (request('tipo') != "empty") && (request('estado') == "empty")){
            $qry = $qry->where('adm', $tipo);
        }

        //Filtrar Estado (Bloqueado/Desbloqueado)
        if (!$request->filled('name') && !$request->filled('email')  && (request('tipo') == "empty") && (request('estado') != "empty")){
            $qry = $qry->where('bloqueado', $estado);
        }

        //Filtrar Nome e Email
        if ($request->filled('name') && $request->filled('email') && (request('tipo') == "empty") && (request('estado') == "empty")){
            $qry = $qry->where('name', 'LIKE', "%{$request->query('name')}%")
                       ->where('email', 'LIKE', "%{$request->query('email')}%");
        }

        //Filtrar Nome e Tipo
        if ($request->filled('name') && !$request->filled('email') && (request('tipo') != "empty") && (request('estado') == "empty")){
            $qry = $qry->where('name', 'LIKE', "%{$request->query('name')}%")
                       ->where('adm', $tipo);
        }

        //Filtrar Nome e Estado
        if ($request->filled('name') && !$request->filled('email') && (request('tipo') == "empty") && (request('estado') != "empty")){
            $qry = $qry->where('name', 'LIKE', "%{$request->query('name')}%")
                       ->where('bloqueado', $estado);
        }

        //Filtrar Email e Tipo
        if (!$request->filled('name') && $request->filled('email') && (request('tipo') != "empty") && (request('estado') == "empty")){
            $qry = $qry->where('email', 'LIKE', "%{$request->query('email')}%")
                       ->where('adm', $tipo);
        }

        //Filtrar Email e Estado
        if (!$request->filled('name') && $request->filled('email') && (request('tipo') == "empty") && (request('estado') != "empty")){
            $qry = $qry->where('email', 'LIKE', "%{$request->query('email')}%")
                       ->where('bloqueado', $estado);
                       
        }

        /*//Filtrar Estado e Tipo 
        if (!$request->filled('name') && !$request->filled('email') && (request('tipo') != "empty") && (request('estado') != "empty")){
            
            $qry = $qry->where('adm', $tipo)
                       ->where('bloqueado', $estado);
                       
        }*/

        //Filtrar Nome, Email, Estado, e Tipo
        if ($request->filled('name') && $request->filled('email') && (request('tipo') != "empty") && (request('estado') != "empty")){
            $qry = $qry->where('name', 'LIKE', "%{$request->query('name')}%")
                       ->where('email', 'LIKE', "%{$request->query('email')}%")
                       ->where('bloqueado', $estado)
                       ->where('adm', $tipo);
                       
        }

        $users = $qry->paginate(10);

        return view('users.perfil')->withUsers($users)->withUser($user);
    }

    public function manageblock(){

        $user_id = request('block_user');
        $user = User::find($user_id);
        
        if(auth()->user()->id != $user->id){
            $user->bloqueado = !$user->bloqueado;
            $user->save();
        }

        return redirect()->route('perfis');
    }


    public function managepromote(){

        $user_id = request('block_promote');
        
        $user = User::find($user_id);
        
        if(auth()->user()->id != $user->id){
            $user->adm = !$user->adm;
            $user->save();
        }

        return redirect()->route('perfis');
    }


}
