<?php

use Illuminate\Database\Seeder;

class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_subcatergorys = [
            ['product_category_id' => 1,'name' => '収納家具'],
            ['product_category_id' => 1,'name' => '寝具'],
            ['product_category_id' => 1,'name' => 'ソファ'],
            ['product_category_id' => 1,'name' => 'ベッド'],
            ['product_category_id' => 1,'name' => '照明'],
            ['product_category_id' => 2,'name' => 'テレビ'],
            ['product_category_id' => 2,'name' => '掃除機'],
            ['product_category_id' => 2,'name' => 'エアコン'],
            ['product_category_id' => 2,'name' => '冷蔵庫'],
            ['product_category_id' => 2,'name' => 'レンジ'],
            ['product_category_id' => 3,'name' => 'トップス'],
            ['product_category_id' => 3,'name' => 'ボトム'],
            ['product_category_id' => 3,'name' => 'ワンピース'],
            ['product_category_id' => 3,'name' => 'ファッション小物'],
            ['product_category_id' => 3,'name' => 'ドレス'],
            ['product_category_id' => 4,'name' => 'ネイル'],
            ['product_category_id' => 4,'name' => 'アロマ'],
            ['product_category_id' => 4,'name' => 'スキンケア'],
            ['product_category_id' => 4,'name' => '香水'],
            ['product_category_id' => 4,'name' => 'メイク'],
            ['product_category_id' => 5,'name' => '旅行'],
            ['product_category_id' => 5,'name' => 'ホビー'],
            ['product_category_id' => 5,'name' => '写真集'],
            ['product_category_id' => 5,'name' => '小説'],
            ['product_category_id' => 5,'name' => 'ライフスタイル'],
        ];
        DB::table('product_subcatergorys')->insert($product_subcatergorys);
    }
}
