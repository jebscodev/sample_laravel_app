<?php

namespace App;

use Illuminate\Support\Str;
use App\BaseModel;

class Project extends BaseModel
{
    // whitelist for mass assignable attributes
    protected $fillable = [
        'name',
        'location',
        'area',
        'price_variation',
        'base_price',
        'standard_floor_area',
        'excess_of_sqm',
        'price_per_sqm',
        'premium',
        'commission',
        'nsp',
        'vat',
        'reg_fee',
        'transfer_tax',
        'doc_stamps',
        'required_dp',
        'misc_home_auto',
        'status'
    ];

    // cast as <data_type> upon return
    protected $casts = [
        'area' => 'decimal:2',
        'excess_of_sqm' => 'decimal:2',
        'price_per_sqm' => 'decimal:2',
        'premium' => 'decimal:2',
        'commission' => 'decimal:2',
        'nsp' => 'decimal:2',
        'vat' => 'decimal:2',
        'reg_fee' => 'decimal:2',
        'transfer_tax' => 'decimal:2',
        'doc_stamps' => 'decimal:2',
        'required_dp' => 'decimal:2',
        'misc_home_auto' => 'decimal:2',
    ];

    public function unit_types() {
        return $this->belongsToMany('App\UnitType', 'project_unit_type')
            ->withPivot('amount', 'home_automation');
    }
    
    public function processing_days() {
        return $this->belongsToMany('App\ProcessingDay', 'project_processing_day')
            ->withPivot('no_of_days');
    }

    public function other_charges() {
        return $this->belongsToMany('App\OtherCharge', 'project_other_charge')
            ->withPivot('percentage');
    }

    public function units() {
        return $this->hasMany('App\Unit');
    }

    public function unsold_units() {
        return $this->hasMany('App\Unit')->where('sale_status', 0);
    }

    public function clients() {
        return $this->hasMany('App\Client');
    }

    public function attachPivot($data) {
        foreach ($data as $relationship => $records){
            $pivot = [];
            foreach ($records as $record) {
                $id = $record['id'];
                unset($record['id']);
                $pivot[$id] = $record;
            }
            $this->$relationship()->attach($pivot);
        }
    }

    public function updatePivot($data) {
        foreach ($data as $relationship => $records){
            if (!empty($records)) {
                foreach ($records as $record) {
                    $id = $record['id'];
                    unset($record['id']);

                    $field = Str::singular($relationship);
                    if ($this->$relationship()->where($field.'_id', $id)->exists()) {
                        $this->$relationship()->updateExistingPivot($id, $record);
                    } else {
                        $this->$relationship()->attach([$id => $record]);
                    }
                }
            } else {
                $this->$relationship()->detach();
            }
        }

    }
}
