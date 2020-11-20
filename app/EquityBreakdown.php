<?php

namespace App;

use App\BaseModel;

class EquityBreakdown extends BaseModel
{
    protected $table = 'equities_breakdown';
    
    protected $fillable = [
        'equity_no',
        'due_date',
        'monthly_equity',
        'penalty',
        'payment_status',
        'equity_id',
        'equity_payment_id'
    ];

    protected $casts = [
        'monthly_equity' => 'decimal:2',
        'penalty' => 'decimal:2'
    ];

    public function equity() {
        return $this->belongsTo('App\Equity');
    }

    public function equity_payment() {
        return $this->belongsTo('App\EquityPayment');
    }
}
