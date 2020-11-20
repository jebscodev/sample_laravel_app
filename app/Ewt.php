<?php

namespace App;

use App\BaseModel;

class Ewt extends BaseModel
{
    protected $fillable = [
        'ewt_amount',
        'rcp_date',
        'est_release_date',
        'actual_release_date',
        'date_paid',
        'total_days',
        'kra',
        'client_id'
    ];

    protected $casts = [
        'ewt_amount' => 'decimal:2'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
