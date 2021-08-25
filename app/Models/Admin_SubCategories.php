<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin_SubCategories extends Model
{
    use SoftDeletes;
    protected $table = 'product_subcategories';
    protected $fillable = ['subcategory_name','id','parent_category_id'];
}
