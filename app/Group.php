<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function reports()
    {
        return $this->hasMany('App\Report');
    }
}
