<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasTable('products')){
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('スレッドID');
                $table->integer('member_id')->nullable(false)->comment('会員ID');
                $table->integer('product_category_id')->nullable(false)->comment('カテゴリID');
                $table->integer('product_subcategory_id')->nullable(false)->comment('サブカテゴリID');
                $table->string('name',255)->nullable(false)->comment('商品名');
                $table->string('imege_1',255)->nullable()->default(null)->comment('写真１');
                $table->string('imege_2',255)->nullable()->default(null)->comment('写真2');
                $table->string('imege_3',255)->nullable()->default(null)->comment('写真3');
                $table->string('imege_4',255)->nullable()->default(null)->comment('写真4');
                $table->text('product_content')->nullable(false)->comment('商品説明');
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
        Schema::dropIfExists('products');
    }
}
