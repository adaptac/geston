<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $fillable =[

        'nome_completo',
        'email',
        'telemovel',
        'username',
        'password',
        'imgURL',
        'level'

    ];
}

