<?php

namespace App;

use App\BaseModel;

class UnitType extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function projects() {
        return $this->belongsToMany('App\Project', 'project_unit_type')
            ->withPivot('amount', 'home_automation');
    }

    public function units() {
        return $this->hasMany('App\Unit');
    }
}
