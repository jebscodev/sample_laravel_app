<?php

namespace App;

use App\BaseModel;

class Unit extends BaseModel
{
    protected $fillable = [
        'project_id',
        'unit_type_id',
        'unit_no',
        'level_no',
        'lot_no',
        'area',
        'is_premium',
        'price_per_sqm',
        'excess_amount',
        'excess_of_sqm_amount',
        'premium_amount',
        'base_price_amount',
        'commission_incentive_amount',
        'nsp_amount',
        'vat_amount',
        'reg_fee_amount',
        'home_automation_amount',
        'transfer_tax_amount',
        'doc_stamp',
        'misc_amount',
        'total_other_charges',
        'reservation_fee',
        'tcp',
        'status',
        'sale_status'
    ];

    // cast as <data_type> upon return
    protected $casts = [
        'area' => 'decimal:2',
        'price_per_sqm' => 'decimal:2',
        'excess_amount' => 'decimal:2',
        'excess_of_sqm_amount' => 'decimal:2',
        'premium_amount' => 'decimal:2',
        'base_price_amount' => 'decimal:2',
        'commission_incentive_amount' => 'decimal:2',
        'nsp_amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'reg_fee_amount' => 'decimal:2',
        'home_automation_amount' => 'decimal:2',
        'transfer_tax_amount' => 'decimal:2',
        'doc_stamp' => 'decimal:2',
        'misc_amount' => 'decimal:2',
        'total_other_charges' => 'decimal:2',
        'reservation_fee' => 'decimal:2',
        'tcp' => 'decimal:2'
    ];

    public function unit_type() {
        return $this->belongsTo('App\UnitType');
    }

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function client() {
        return $this->hasOne('App\Client');
    }

    public function equity() {
        return $this->hasOne('App\Equity');
    }
}
