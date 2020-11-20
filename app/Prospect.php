<?php

namespace App;

use App\BaseModel;

class Prospect extends BaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'email_address',
        'contact_no',
        'tin_no',
        'status'
    ];

    public function client() {
        return $this->hasOne('App\Client');
    }
}
