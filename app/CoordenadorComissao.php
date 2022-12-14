<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoordenadorComissao extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function editais(){
        return $this->hasMany('App\Evento');
    }

    public function trabalho(){
    	return $this->hasMany('App\Trabalho', 'coordenador_id');
    }

}
