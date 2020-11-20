<?php

namespace App;

use App\BaseModel;

class Document extends BaseModel
{
    protected $fillable = [
        'cust_prof',
        'cust_reg',
        'tin_dec',
        'ids',
        'prof_acq',
        'res_agnt',
        'prov_rcpt',
        'term_sht',
        'birth_cert',
        'marriage_cert',
        'cenomar',
        'proof_of_income',
        'proof_of_billing',
        'pdc',
        'requirements_status',
        'status',
        'date_completed',
        'remarks'
    ];

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function countSubmitted() {
        $ctr = 0;
        foreach ($this->fillable as $field) {
            if (!in_array($field, ['requirements_status','status','date_completed','remarks'])) {
                if ($this->$field == '1')
                    $ctr++;
            }
        }
        return $ctr;
    }
}
