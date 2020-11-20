<?php

namespace App;

use App\BaseModel;

class Broker extends BaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'brokerage_firm',
        'email_address',
        'contact_no',
        'tin_no',
        'payment_schedule',
        'status'
    ];

    public function scopeActive($query) {
        $query->where('status', 1);
    }

    public function clients() {
        return $this->hasMany('App\Client');
    }
}
