<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSubcatergorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_subcategories')){
            Schema::create('product_subcategories', function (Blueprint $table) {
                $table->increments('id')->comment('サブカテゴリID');
                $table->integer('parent_category_id')->unsigned()->nullable(false)->comment('親カテゴリID');
                $table->string('subcategory_name',255)->nullable(false)->comment('サブカテゴリ名');
                $table->timestamps();
                $table->softDeletes();

                // 親カテゴリーIDは、必ずproduct_categoriesに存在する事！
                $table->foreign('parent_category_id')
                    ->references('id')
                    ->on('product_categories');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_subcategories');
    }
}
