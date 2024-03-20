<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loans extends Model
{
    protected $fillable =[

        'reference',
        'id_client',
        'id_user',
        'moneytopay',
        'debt',
        'status'

    ];
}
