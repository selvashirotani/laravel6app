<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('admins')){
            Schema::create('admins', function (Blueprint $table) {
                $table->bigIncrements('id')->nullable(false)->comment('管理者ID');;
                $table->string('name',255)->nullable(false)->comment('氏名');
                $table->string('login_id',255)->nullable(false)->comment('ログインID');
                $table->string('password',255)->nullable(false)->comment('パスワード');
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
        Schema::dropIfExists('admins');
    }
}
