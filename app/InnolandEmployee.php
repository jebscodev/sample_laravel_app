<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InnolandEmployee extends Model
{
    // pull employees from innoland db
    protected $connection = 'innoland_mysql';
    protected $table = 'employees';
}
