<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $table = 'users';

    public $timestamps = false;


    public function role()
    {
        return $this->belongsTo('App\Role');
    }


    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    
    public function reports()
    {
        return $this->hasMany('App\Report','created_by','id');
    }

    public function hasRole($role)
    {
        if($this->role->name == $role)
        {
            return true;
        }
        return false;
    }

    public function allowed_groups()
    {
        $user_groups = [];

        foreach($this->groups as $group)
        {
            $user_groups[] = $group->id;
        }
        
        return $user_groups;
    }

}
