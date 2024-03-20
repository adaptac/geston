<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    
    protected $fillable = [

        'descricao',
        'precounitario',
        'quantidade',
        'codigobarra',
        'istributable',
        'imgURL'

    ];

}
