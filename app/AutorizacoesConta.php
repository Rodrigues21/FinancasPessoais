<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacoesConta extends Model
{
    protected $table = "autorizacoes_contas";

    /*protected $primaryKey = ['user_id, conta_id'};
    protected $keyType = 'integer';*/
    
    public $timestamps = false;

}