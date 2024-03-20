<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products_category extends Model
{
    
    protected $fillable =[

        'id_products',
        'id_categoria'

    ];

}
