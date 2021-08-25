<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin_Categories extends Model
{
    use SoftDeletes;
    protected $table = 'product_categories';
    protected $fillable = ['id','category_name'];

    //リレーション
    public function product_subcategories()
    {
        return $this->hasMany('App\Models\SubCategories','parent_category_id','id');
    }

   
}
