<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends Model
{

    use SoftDeletes;

    public $timestamps=false;

    protected $fillable = [
        'conta_id', 'data', 'valor', 'saldo_inicial_', 'saldo_final', 'tipo', 'categoria_id', 'descricao', 'imagem_doc'
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
