<?php

namespace App;

use App\BaseModel;

class ProcessingDay extends BaseModel
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function projects() {
        return $this->belongsToMany('App\Project', 'project_processing_day')
            ->withPivot('no_of_days');
    }
}
