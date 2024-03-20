<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_notifications extends Model
{
    protected $fillable =[

        'id_user',
        'id_notification'

    ];
}
