<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Module extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'is_module',
        'is_child',
        'menu_parent_id',
        'icon',
        'status'
    ];

    public function scopeActive($query) {
        $query->where('status', 1);
    }

    public function scopeIsModule($query) {
        $query->where('is_module', 1);
    }

    // not needed, created a pivot table model
    // public function roles() {
    //     return $this->belongsToMany('App\Role', 'role_module_tagging')
    //         ->using('App\RoleModuleTagging')
    //         ->withPivot(['read', 'write', 'update'])
    //         ->withTimestamps()
    //         ->as('tagged');
    // }
}
