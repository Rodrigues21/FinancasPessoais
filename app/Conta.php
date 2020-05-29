<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use SoftDeletes;

    public $timestamps=false;    

    protected $fillable = [
        'nome', 'saldo_abertura', 'descricao'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'autorizacoes_contas')->withPivot('so_leitura');
    }

    public function movimentos(){
        return $this->hasMany('App\Movimento');
        
    }
}
