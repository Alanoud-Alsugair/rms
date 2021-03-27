<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = false;

    //each role may has more than one user 
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
