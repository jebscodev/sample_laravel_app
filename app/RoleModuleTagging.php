<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModuleTagging extends Pivot
{
    use SoftDeletes;
    
    public $incrementing = true;
    public $timestamps = false;
    public $fillable = [
        'role_id',
        'module_id',
        'read',
        'write',
        'update'
    ];
}
