<?php

use Illuminate\Database\Seeder;

class CategorysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = ['name' => 'インテリア'];
        DB::table('product_categorys')->insert($param);

        $param = ['name' => '家電'];
        DB::table('product_categorys')->insert($param);

        $param = ['name' => 'ファッション'];
        DB::table('product_categorys')->insert($param);

        $param = ['name' => '美容' ];
        DB::table('product_categorys')->insert($param);

        $param = ['name' => '本・雑誌' ];
        DB::table('product_categorys')->insert($param);
    }
}
