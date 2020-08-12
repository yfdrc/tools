<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = ['department_id', 'name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    private $SubDepartments = [];

    public function getSubDepartments($id = null)
    {
        if($id == null){
            $id = $this->department->id;
            $this->SubDepartments = array_add($this->SubDepartments, $this->department->id, $this->department->name);
        }
        $subs = Department::where("parent_id", "=", $id)->get();
        if($subs != null) {
            foreach ($subs as $sub) {
                $this->SubDepartments = array_add($this->SubDepartments, $sub->id, $sub->name);
                $this->getSubDepartments($sub->id);
            }
        }
        return $this->SubDepartments;
    }

    public function hasPermission(string $permission):bool
    {
        foreach ($this->roles as $role) {
            if($role->permissions->contains('name', $permission)) return true;
        }
        return false;
    }

    public static function getUsersAll($right=-1)
    {
        if (is_numeric($right)) {
            if($right == -1) $right = auth()->user()->getRolesRight();
            $users = User::get();
            $i = 0;
            foreach ($users as $user) {
                if ($user->getRolesRight() > $right) {
                    array_forget($users, $i);
                }
                $i++;
            }
            return $users;
        }
    }

    public function getRolesRight()
    {
        $fhz = $this->roles->max("right");
        if($fhz == null){ return 0;}
        return $fhz;
    }

    public function getRolesLabel($spitstr = " "):string
    {
        $ps = " ";
        foreach ($this->roles as $role) {
            $ps = $ps . $role->label . $spitstr;
        }
        return $ps;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
