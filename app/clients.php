<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    
    protected $fillable =[

        'nome_completo',
        'contacto',
        'nuitORbi'

    ];

}
