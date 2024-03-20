<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    protected $fillable =[

        'nome_completo',
        'email',
        'telefone',
        'nuit'

    ];
}
