<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    public $timestamps = false;

    public function reports()
    {
        return $this->belongsToMany('App\Report');
    }
}
