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
        if(!Schema::hasTable('product_subcatergorys')){
            Schema::create('product_subcatergorys', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('サブカテゴリID');
                $table->integer('product_category_id')->nullable(false)->comment('カテゴリID');
                $table->string('name',255)->nullable(false)->comment('サブカテゴリ名');
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
        Schema::dropIfExists('product_subcatergorys');
    }
}
