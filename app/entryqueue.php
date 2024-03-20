<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class entryqueue extends Model
{
    
	protected $fillable =[

        'id_product',
        'entryqty',
        'unitprice'

    ];

}
