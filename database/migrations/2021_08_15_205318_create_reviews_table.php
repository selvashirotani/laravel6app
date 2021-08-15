<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('reviews')){
            Schema::create('reviews', function (Blueprint $table) {
                $table->increments('id')->comment('コメントID');
                $table->integer('member_id')->nullable(false)->comment('会員ID');
                $table->integer('product_id')->nullable(false)->comment('商品ID');
                $table->integer('evaluation')->nullable(false)->comment('評価');
                $table->text('comment')->nullable(false)->comment('商品コメント');
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
        Schema::dropIfExists('reviews');
    }
}
