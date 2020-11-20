<?php

namespace App;

use App\BaseModel;

class CtsFile extends BaseModel
{
    protected $fillable = [
        'date_printed',
        'date_signed',
        'date_notarized',
        'cts_status',
        'total_days',
        'kra',
        'client_id'
    ];

    protected $casts = [];

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
