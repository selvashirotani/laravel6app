<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('会員ID');
                $table->string('name_sei',255)->nullable(false)->comment('氏名（姓）');
                $table->string('name_mei',255)->nullable(false)->comment('氏名（名）');
                $table->string('nickname',255)->nullable(false)->comment('ニックネーム');
                $table->integer('gender')->nullable(false)->comment('性別（1=男性、2=女性）');
                $table->string('email',255)->nullable(false)->unique()->comment('メールアドレス');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password',255)->nullable(false)->comment('パスワード');
                $table->integer('auth_code')->nullable()->default(null)->comment('認証コード');
                $table->rememberToken();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
