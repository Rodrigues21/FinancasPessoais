<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function movimentos(){
        return $this->hasMany('App\Movimento');
    }
}
