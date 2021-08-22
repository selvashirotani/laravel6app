<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class reviews extends Model
{
    use SoftDeletes;
    protected $table = "reviews";
    protected $dates = ['deleted_at'];
    protected $fillable = ["member_id","product_id","evaluation","comment"];
}
