<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products_suppliers extends Model
{
    
    protected $fillable =[

        'id_products',
        'id_suppliers'

    ];

}
