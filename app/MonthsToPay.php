<?php

namespace App;

use App\BaseModel;

class MonthsToPay extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'discount'
    ];

    protected $casts = [
        'discount' => 'decimal:2'
    ];
}
