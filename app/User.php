<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\MUser;
use App\Role;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','defaultbranch'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function is_admin(){
        $role_id = MUser::on(Auth::user()->db_name)->where('museremail',$this->email)->first()->musercategory;

        if($role_id == 1){
            return true;
        } else {
            return false;
        }
    }

    public function has_role($column_name){
        $role_id = MUser::on(Auth::user()->db_name)->where('museremail',$this->email)->first()->musercategory;
        $role = Role::on(Auth::user()->db_name)->where('id',$role_id)->first();
        if($role->{$column_name} == 1){
            return 1;
        } else {
            return 0;
        }
    }
}
