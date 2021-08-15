<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    protected $table = "reviews";
    protected $fillable = ["member_id","product_id","evaluation","comment"];
}
