<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator; //バリデーションを使うから必要
use App\Models\items;
use App\Models\members; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し
use Illuminate\Support\Facades\DB; //DBクラス
use App\Providers\RouteServiceProvider;

class ProductsController extends Controller
{
    private $formItems = ["name","product_category_id", "product_subcategory_id","product_content"];
    private $validator = [
        "name" => "required|string|max:100",
        "product_category_id" => "required|exists:product_categories,id",
        "product_subcategory_id" => "required|exists:product_subcategories,id",
        "product_content" => "required|string|max:500|",        
    ];

    public function all(Request $request){

        //検索機能
        $products_id = $request->input('products_id');
        $free_word = $request->input('free_word');

        if(!empty($products_id) && !empty($free_word)){
            $query = items::where('id',$products_id)
            ->where(function($query)use($free_word){
                $query->where('name','like','%'.$free_word .'%')
                        ->orWhere('product_content','like','%'.$free_word .'%');
            });
          
        }elseif(empty($products_id) && !empty($free_word)){
            $query = items::where(function($query)use($free_word){
                $query->where('name','like','%'.$free_word .'%')
                        ->orWhere('product_content','like','%'.$free_word .'%');
            });

        }elseif(!empty($products_id) && empty($free_word)){
            $query = items::query();
                $query->where('id',$products_id);
        }else{
            $query = items::query();
        }

        if(!empty($request->sort)){
            $sort = $request->sort;
            $direction = $request->direction;
        }else{
            $sort = 'id';
            $direction = 'desc';
        }

        if($sort == "id" && $direction == "asc"){
            $items = $query->orderBy('id', 'asc')->sortable()->paginate(10);
        }elseif($sort == "id" && $direction == "desc"){
            $items = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "asc"){
            $items = $query->orderBy('created_at', 'asc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "desc"){
            $items = $query->orderBy('created_at', 'desc')->sortable()->paginate(10);
        }else{
            $items = $query->orderBy($id, 'desc')->sortable()->paginate(10);
        }
            

        return view("admin.products.all",compact(
            'items'
        ));
    }



    public function show(Request $request){
        
        // if(!empty($request->session())){
        //     $request->session()->forget("image_input_1");
        //     $request->session()->forget("image_input_2");
        //     $request->session()->forget("image_input_3");
        //     $request->session()->forget("image_input_4");
        // }

        $category = Categories::pluck('category_name','id');
            $subcategory = SubCategories::pluck('subcategory_name','id');

            $path_image_1 = $request->session()->get("image_input_1");
            $path_image_2 = $request->session()->get("image_input_2");
            $path_image_3 = $request->session()->get("image_input_3");
            $path_image_4 = $request->session()->get("image_input_4");


        if(!empty($request->id)){

            $id = $request->id;
            $products = items::where('id',$id)
                    ->get();
            if($path_image_4 ){
                return view("admin.products.form",compact(
                    'products','category','subcategory','path_image_1','path_image_2','path_image_3','path_image_4'
                ));
            }
            elseif($path_image_3 ){
                return view("admin.products.form",compact(
                    'products','category','subcategory','path_image_1','path_image_2','path_image_3'
                ));
            }
            elseif($path_image_2 ){
                return view("admin.products.form",compact(
                    'products','category','subcategory','path_image_1','path_image_2'
                ));
            }
            elseif($path_image_1 ){
                return view("admin.products.form",compact(
                    'products','category','subcategory','path_image_1'
                ));
            }else{
                return view("admin.products.form",compact(
                    'products','category','subcategory'
                ));
            }

        }else{
            //カテゴリ(追加)

            if($path_image_4 ){
                return view("admin.products.form",compact(
                    'category','subcategory','path_image_1','path_image_2','path_image_3','path_image_4'
                ));
            }
            elseif($path_image_3 ){
                return view("admin.products.form",compact(
                    'category','subcategory','path_image_1','path_image_2','path_image_3'
                ));
            }
            elseif($path_image_2 ){
                return view("admin.products.form",compact(
                    'category','subcategory','path_image_1','path_image_2'
                ));
            }
            elseif($path_image_1 ){
                return view("admin.products.form",compact(
                    'category','subcategory','path_image_1'
                ));
            }else{
                return view("admin.products.form",compact(
                    'category','subcategory'
                ));
            }
        }


    }


    function post(Request $request){
        
            //画像処理
            if($request->hasFile('imege_4')){

                $input_image_1 = $request->file('imege_1');
                $input_image_2 = $request->file('imege_2');
                $input_image_3 = $request->file('imege_3');
                $input_image_4 = $request->file('imege_4');

                if($input_image_1) {
                    //アップロードされた画像を保存する
                    $path_image_1 = $input_image_1->store('uploads',"public");
                }
                if($input_image_2) {
                    //アップロードされた画像を保存する
                    $path_image_2 = $input_image_2->store('uploads',"public");
                }
                if($input_image_3) {
                    //アップロードされた画像を保存する
                    $path_image_3 = $input_image_3->store('uploads',"public");
                }
                if($input_image_4) {
                    //アップロードされた画像を保存する
                    $path_image_4 = $input_image_4->store('uploads',"public");
                }

                $request->session()->put("image_input_1", $path_image_1);
                $request->session()->put("image_input_2", $path_image_2);
                $request->session()->put("image_input_3", $path_image_3);
                $request->session()->put("image_input_4", $path_image_4);
            }
            elseif($request->hasFile('imege_3')){

                $input_image_1 = $request->file('imege_1');
                $input_image_2 = $request->file('imege_2');
                $input_image_3 = $request->file('imege_3');

                if($input_image_1) {
                    //アップロードされた画像を保存する
                    $path_image_1 = $input_image_1->store('uploads',"public");
                }
                if($input_image_2) {
                    //アップロードされた画像を保存する
                    $path_image_2 = $input_image_2->store('uploads',"public");
                }
                if($input_image_3) {
                    //アップロードされた画像を保存する
                    $path_image_3 = $input_image_3->store('uploads',"public");
                }

                $request->session()->put("image_input_1", $path_image_1);
                $request->session()->put("image_input_2", $path_image_2);
                $request->session()->put("image_input_3", $path_image_3);
            }
            elseif($request->hasFile('imege_2')){

                $input_image_1 = $request->file('imege_1');
                $input_image_2 = $request->file('imege_2');

                if($input_image_1) {
                    //アップロードされた画像を保存する
                    $path_image_1 = $input_image_1->store('uploads',"public");
                }
                if($input_image_2) {
                    //アップロードされた画像を保存する
                    $path_image_2 = $input_image_2->store('uploads',"public");
                }

                $request->session()->put("image_input_1", $path_image_1);
                $request->session()->put("image_input_2", $path_image_2);
            }
            //１つ目
            elseif($request->hasFile('imege_1')){

                $input_image_1 = $request->file('imege_1');

                if($input_image_1) {
                    //アップロードされた画像を保存する
                    $path_image_1 = $input_image_1->store('uploads',"public");
                }

                $request->session()->put("image_input_1", $path_image_1);
            }
            //ここまで

            $input = $request->only("id","name","product_category_id", "product_subcategory_id","product_content");     

            $validator = Validator::make($input, $this->validator);


            if(!empty($request->id)){

                if($validator->fails()){
                    return redirect()->action("Admin\ProductsController@show",['id'=>$request->id])
                        ->withInput()
                        ->withErrors($validator);
                }
                $request->session()->put("item_input", $input);
                return redirect()->action("Admin\ProductsController@confirm",['id'=>$request->id]);
            }else{
                if($validator->fails()){
                    return redirect()->action("Admin\ProductsController@show")
                        ->withInput()
                        ->withErrors($validator);
                }
                $request->session()->put("item_input", $input);
                return redirect()->action("Admin\ProductsController@confirm");
            }
            
            
        
    }


    function confirm(Request $request){
        //confirm()関数で呼び出されている。
        $category = Categories::pluck('category_name','id');
        $subcategory = SubCategories::pluck('subcategory_name','id');


        //セッションから値を取り出す
		$input = $request->session()->get("item_input");
        $replacements1 = array('product_content' =>nl2br($input['product_content']));
        $input = array_replace($input,$replacements1);

        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("Admin\ProductsController@show");
		}

        $path_image_1 = $request->session()->get("image_input_1");
        $path_image_2 = $request->session()->get("image_input_2");
        $path_image_3 = $request->session()->get("image_input_3");
        $path_image_4 = $request->session()->get("image_input_4");

        if(!empty($request->id)){
            $id = $request->id;
            $product = items::where('id',$id)
                    ->get();
            $products =json_decode(json_encode($product), true);
            if($path_image_4 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','products','path_image_1','path_image_2','path_image_3','path_image_4'
                ));
            }
            elseif($path_image_3 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','products','path_image_1','path_image_2','path_image_3'
                ));
            }
            elseif($path_image_2 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','products','path_image_1','path_image_2'
                ));
            }
            elseif($path_image_1 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','products','path_image_1'
                ));
            }else{
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','products'
                ));
            }
        }else{
            if($path_image_4 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','path_image_1','path_image_2','path_image_3','path_image_4'
                ));
            }
            elseif($path_image_3 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','path_image_1','path_image_2','path_image_3'
                ));
            }
            elseif($path_image_2 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','path_image_1','path_image_2'
                ));
            }
            elseif($path_image_1 ){
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input','path_image_1'
                ));
            }else{
                return view("admin.products.form_confirm",compact(
                    'category','subcategory','input'
                ));
            }
        }
        
        
    }

    public function send(Request $request){

        //セッションから値を取り出す
        $input = $request->session()->get("item_input");

        $path_image_1 = $request->session()->get("image_input_1");
        $path_image_2 = $request->session()->get("image_input_2");
        $path_image_3 = $request->session()->get("image_input_3");
        $path_image_4 = $request->session()->get("image_input_4");

        //セッションに値が無い時はフォームに戻る
        if(!$input){
            return redirect()->action("ItemFormController@show");
        }

        if(empty($input['id'])){
            items::all();//モデルクラス(items.php)で行ったこといれるよ。


            \DB::beginTransaction();
            try{
                $item = new items;
    
                $item->member_id = 0;
                $item->name = $input["name"];
                $item->product_category_id = $input["product_category_id"];
                $item->product_subcategory_id = $input["product_subcategory_id"];
                $item->product_content = $input["product_content"];
                if($path_image_4){
                    $item->imege_1 = $path_image_1;
                    $item->imege_2 = $path_image_2;
                    $item->imege_3 = $path_image_3;
                    $item->imege_4 = $path_image_4;
                }
                elseif($path_image_3){
                    $item->imege_1 = $path_image_1;
                    $item->imege_2 = $path_image_2;
                    $item->imege_3 = $path_image_3;
                }
                elseif($path_image_2){
                    $item->imege_1 = $path_image_1;
                    $item->imege_2 = $path_image_2;
                }
                if($path_image_1){
                    $item->imege_1 = $path_image_1;
                }
                
                $item->save();
                \DB::commit();
            }catch(\Throwable $e){
                \DB::rollback();
                abort(500); //500エラーを表示する。
            }
        }elseif(!empty($input['id'])){
            $item = items::where('id',$input['id'])->first();
            $item->member_id = 0;
            $item->name = $input["name"];
            $item->product_category_id = $input["product_category_id"];
            $item->product_subcategory_id = $input["product_subcategory_id"];
            $item->product_content = $input["product_content"];
            if($path_image_4){
                $item->imege_1 = $path_image_1;
                $item->imege_2 = $path_image_2;
                $item->imege_3 = $path_image_3;
                $item->imege_4 = $path_image_4;
            }
            elseif($path_image_3){
                $item->imege_1 = $path_image_1;
                $item->imege_2 = $path_image_2;
                $item->imege_3 = $path_image_3;
            }
            elseif($path_image_2){
                $item->imege_1 = $path_image_1;
                $item->imege_2 = $path_image_2;
            }
            if($path_image_1){
                $item->imege_1 = $path_image_1;
            }

            $item->save();

        }
        



        // 二重送信対策(2021080415:51)
        $request->session()->regenerateToken();

        //セッションを空にする
        $request->session()->forget("item_input");
        $request->session()->forget("image_input_1");
        $request->session()->forget("image_input_2");
        $request->session()->forget("image_input_3");
        $request->session()->forget("image_input_4");

        return redirect()->action("Admin\ProductsController@all");
    }
    

}
