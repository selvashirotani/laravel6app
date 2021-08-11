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
        $param = ['category_name' => 'インテリア'];
        DB::table('product_categories')->insert($param);

        $param = ['category_name' => '家電'];
        DB::table('product_categories')->insert($param);

        $param = ['category_name' => 'ファッション'];
        DB::table('product_categories')->insert($param);

        $param = ['category_name' => '美容' ];
        DB::table('product_categories')->insert($param);

        $param = ['category_name' => '本・雑誌' ];
        DB::table('product_categories')->insert($param);
    }
}
