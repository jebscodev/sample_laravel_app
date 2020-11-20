<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Role extends BaseModel
{
    protected $fillable = [
        'name', 'description', 'status'
    ];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeInactive($query) {
        return $query->where('status', 0);
    }

    public function users() {
        return $this->hasMany('App\User');
    }

    public function tagged_modules() {
        return $this->belongsToMany('App\Module', 'role_module_tagging')
            ->using('App\RoleModuleTagging')
            ->withPivot(['read', 'write', 'update']);
            //->as('tagged');
    }
}
