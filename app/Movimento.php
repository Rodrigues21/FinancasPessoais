<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    public $timestamps=false;

    protected $fillable = [
        'nome', 'saldo_abertura', 'descricao'
    ];

    public function conta()
    {
        return $this->belongsTo('App\Conta');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }
}
