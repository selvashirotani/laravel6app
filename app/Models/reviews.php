<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;


class reviews extends Model
{
    use Sortable;
    use SoftDeletes;
    protected $table = "reviews";
    protected $dates = ['deleted_at'];
    protected $fillable = ["member_id","product_id","evaluation","comment"];
}
