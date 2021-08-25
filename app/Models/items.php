<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class items extends Model
{
    use Sortable;
    //use HasFactory;
    protected $table = "products";
    protected $fillable = ["member_id","name","product_category_id", "product_subcategory_id", "imege_1","imege_2","imege_3","imege_4","product_content"];
}
