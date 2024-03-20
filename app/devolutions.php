<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class devolutions extends Model
{
    
	protected $fillable =[

        'id_users',
        'id_products',
        'id_clients',
        'payback',
        'takenback_qty',
        'reference'

    ];

}
