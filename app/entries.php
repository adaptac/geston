<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entries extends Model
{
    
    protected $fillable =[

        'id_user',
        'id_products',
        'id_suppliers',
        'quantity',
        'buy_price'

    ];

}
