<?php

namespace App;

use App\BaseModel;

class Client extends BaseModel
{
    protected $fillable = [
        'tranche_no',
        'client_name',
        'civil_status',
        'address',
        'tin',
        'contact_no',
        'email_address',
        'reservation_date',
        'reservation_amount',
        'equity',
        'months_to_pay',
        'payment_scheme',
        'remarks',
        'total_equity',
        'total_eq_paid_less_reg_fee',
        'monthly_equity',
        'is_vatted',
        'net_selling_price_wo_vat',
        'net_selling_price_w_vat',
        'remaining_balance',
        'tcp',
        'status',
        'prospect_id',
        'project_id',
        'unit_id',
        'broker_id'
    ];

    protected $casts = [
        'reservation_amount' => 'decimal:2',
        'equity' => 'decimal:2',
        'total_equity' => 'decimal:2',
        'total_eq_paid_less_reg_fee' => 'decimal:2',
        'monthly_equity' => 'decimal:2',
        'net_selling_price_wo_vat' => 'decimal:2',
        'net_selling_price_w_vat' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'tcp' => 'decimal:2'
    ];

    public function broker() {
        return $this->belongsTo('App\Broker');
    }

    public function prospect() {
        return $this->belongsTo('App\Prospect');
    }

    public function unit() {
        return $this->belongsTo('App\Unit');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function documents() {
        return $this->hasMany('App\Document');
    }

    public function equities() {
        return $this->hasMany('App\Equity');
    }

    public function equity_payments() {
        return $this->hasMany('App\EquityPayment');
    }

    public function loan_takeout() {
        return $this->hasOne('App\LoanTakeout');
    }

    public function ewt() {
        return $this->hasOne('App\Ewt');
    }

    public function cts_file() {
        return $this->hasOne('App\CtsFile');
    }
}
