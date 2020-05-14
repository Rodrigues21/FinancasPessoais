@extends('layouts.app')

@section('content')
<div class="col-lg-12 text-center">
    <h1 class="mt-5">Bem Vindo!</h1>
    <p class="lead">A Finanças Pessoais é uma aplicação web que permite aos seus {{$users}} utilizadores gerir as suas finanças pessoais!</p>
    <p class="lead">Os Utilizadores possuem atualmente {{$contas}} contas e efetuaram um total de {{$movimentos}} movimentos!</p>
</div>
@endsection
