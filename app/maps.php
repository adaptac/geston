<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class maps extends Model
{
    protected $fillable =[

        'id_product',
        'quantidadeentrada',
        'quantidadesaida'

    ];
}
