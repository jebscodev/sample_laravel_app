<?php

namespace App;

use App\BaseModel;

class LoanTakeout extends BaseModel
{
    protected $fillable = [
        'financing_scheme',
        'loan_status',
        'loan_amount',
        'tcp',
        'variance',
        'status',
        'total_days',
        'kra',
        'client_id'
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
        'tcp' => 'decimal:2',
        'variance' => 'decimal:2'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
