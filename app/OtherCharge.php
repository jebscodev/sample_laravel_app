<?php

namespace App;

use App\BaseModel;

class OtherCharge extends BaseModel
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function projects() {
        return $this->belongsToMany('App\Project', 'project_other_charge')
            ->withPivot('percentage');
    }
}
