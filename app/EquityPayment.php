<?php

namespace App;

use App\BaseModel;

class EquityPayment extends BaseModel
{
    protected $fillable = [
        'date_paid',
        'total_amount_payable',
        'less_advance_payment',
        'remaining_payable',
        'amount_paid',
        'amount_change',
        'is_added_to_advance',
        'receipt_no_equity',
        'receipt_no_penalty',
        'status',
        'client_id'
    ];

    protected $casts = [
        'total_amount_payable' => 'decimal:2',
        'less_advance_payment' => 'decimal:2',
        'remaining_payable' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_change' => 'decimal:2'
    ];

    public function equities_breakdown() {
        return $this->hasMany('App\EquityBreakdown');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }
}
