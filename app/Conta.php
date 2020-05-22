<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    public $timestamps=false;

    protected $fillable = [
        'nome', 'saldo_abertura', 'descricao'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function movimentos(){
        return $this->hasMany('App\Movimento');
    }
}
