<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function getParentName():string
    {
        $fhz = " ";
        if(is_numeric($this->parent_id)) {
            $fhz = Department::find($this->parent_id)->name;
        }
        return $fhz;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
