<?php

namespace App;

use App\BaseModel;

class Equity extends BaseModel
{
    protected $fillable = [
        'unit_id',
        'total_equity',
        'total_equity_paid',
        'total_penalties',
        'total_penalty_paid',
        'remaining_balance',
        'letter_of_notice_status',
        'client_id'
    ];

    protected $casts = [
        'total_equity' => 'decimal:2',
        'total_equity_paid' => 'decimal:2',
        'total_penalties' => 'decimal:2',
        'total_penalty_paid' => 'decimal:2',
        'remaining_balance' => 'decimal:2'
    ];

    public function equities_breakdown() {
        return $this->hasMany('App\EquityBreakdown');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function unit() {
        return $this->belongsTo('App\Unit');
    }
}
