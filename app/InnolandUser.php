<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InnolandUser extends Model
{
    // pull users from innoland db
    protected $connection = 'innoland_mysql';
    protected $table = 'login';
}
