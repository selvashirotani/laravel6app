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
        $product_subcategories = [
            ['parent_category_id' => 1,'subcategory_name' => '収納家具'],
            ['parent_category_id' => 1,'subcategory_name' => '寝具'],
            ['parent_category_id' => 1,'subcategory_name' => 'ソファ'],
            ['parent_category_id' => 1,'subcategory_name' => 'ベッド'],
            ['parent_category_id' => 1,'subcategory_name' => '照明'],
            ['parent_category_id' => 2,'subcategory_name' => 'テレビ'],
            ['parent_category_id' => 2,'subcategory_name' => '掃除機'],
            ['parent_category_id' => 2,'subcategory_name' => 'エアコン'],
            ['parent_category_id' => 2,'subcategory_name' => '冷蔵庫'],
            ['parent_category_id' => 2,'subcategory_name' => 'レンジ'],
            ['parent_category_id' => 3,'subcategory_name' => 'トップス'],
            ['parent_category_id' => 3,'subcategory_name' => 'ボトム'],
            ['parent_category_id' => 3,'subcategory_name' => 'ワンピース'],
            ['parent_category_id' => 3,'subcategory_name' => 'ファッション小物'],
            ['parent_category_id' => 3,'subcategory_name' => 'ドレス'],
            ['parent_category_id' => 4,'subcategory_name' => 'ネイル'],
            ['parent_category_id' => 4,'subcategory_name' => 'アロマ'],
            ['parent_category_id' => 4,'subcategory_name' => 'スキンケア'],
            ['parent_category_id' => 4,'subcategory_name' => '香水'],
            ['parent_category_id' => 4,'subcategory_name' => 'メイク'],
            ['parent_category_id' => 5,'subcategory_name' => '旅行'],
            ['parent_category_id' => 5,'subcategory_name' => 'ホビー'],
            ['parent_category_id' => 5,'subcategory_name' => '写真集'],
            ['parent_category_id' => 5,'subcategory_name' => '小説'],
            ['parent_category_id' => 5,'subcategory_name' => 'ライフスタイル'],
        ];
        DB::table('product_subcategories')->insert($product_subcategories);
    }
}
