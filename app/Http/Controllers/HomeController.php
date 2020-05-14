<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Movimento;
use App\Conta;

class HomeController extends Controller
{
    
    public function index()
    {
        $totalMovimentos = Movimento::count();
        $totalContas = Conta::whereNull('deleted_at')->count();
        $totalUtilizadores = User::count();
        return view('home')
        ->withUsers($totalUtilizadores)
        ->withMovimentos($totalMovimentos)
        ->withContas($totalContas);      
    }
}
