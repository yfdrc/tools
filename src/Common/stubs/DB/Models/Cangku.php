<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cangku extends Model
{
    protected $fillable = [
        "name",
        "address",
        "gly",
    ];

    protected $hidden = [
    ];

}
