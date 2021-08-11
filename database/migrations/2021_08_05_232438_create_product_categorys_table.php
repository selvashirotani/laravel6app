<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_categories')){
            Schema::create('product_categories', function (Blueprint $table) {
                $table->increments('id')->comment('カテゴリID');
                $table->string('category_name',255)->nullable(false)->comment('カテゴリ名');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('product_categories');
    }
}
