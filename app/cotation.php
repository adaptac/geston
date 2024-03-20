<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cotation extends Model
{
    

	protected $fillable =[

        'id_user',
        'id_id_products',
        'id_cliente',
        'valor_liquido',
        'valor_total',
        'quantidade',
        'reference'

    ];
    
}
