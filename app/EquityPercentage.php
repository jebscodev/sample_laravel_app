<?php

namespace App;

use App\BaseModel;

class EquityPercentage extends BaseModel
{
    protected $fillable = [
        'percentage',
        'description'
    ];

    protected $casts = [
        'percentage' => 'decimal:2'
    ];
}
