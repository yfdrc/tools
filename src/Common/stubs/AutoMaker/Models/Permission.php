<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'label', 'description'];

    public function getRolesLabel($spitstr = " ")
    {
        $ps = " ";
        foreach ($this->roles as $role) {
            $ps = $ps . $role->label . $spitstr;
        }
        return $ps;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
