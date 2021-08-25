<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\items; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し
use Validator; 

class ItemsController extends Controller
{
    private $formItems = ["id","category_name","subcategory_names","subcategory_name_1","subcategory_name_2","subcategory_name_3","subcategory_name_4","subcategory_name_5","subcategory_name_6","subcategory_name_7","subcategory_name_8","subcategory_name_9","subcategory_name_10"];

    public function category(Request $request){

        //検索機能
        $category_id = $request->input('category_id');
        $free_word = $request->input('free_word');

        if(!empty($category_id) && !empty($free_word)){
            $query = Categories::where('id',$category_id)
            ->where(function($query)use($free_word){
                $query->where('category_name','like','%'.$free_word .'%')
                        ->orWhereHas('product_subcategories',function($query)use($free_word){
                            $query->where('subcategory_name','like','%'.$free_word .'%');
                        });
            });
          
        }elseif(empty($category_id) && !empty($free_word)){
            $query = Categories::where('category_name','like','%'.$free_word .'%')
                ->orWhereHas('product_subcategories',function($query)use($free_word){
                    $query->where('subcategory_name','like','%'.$free_word .'%');
                });

        }elseif(!empty($category_id) && empty($free_word)){
            $query = Categories::query();
                $query->where('id',$category_id);
        }else{
            $query = Categories::query();
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
            

        return view("admin.items.category",compact(
            'items'
        ));
    }
    
    public function show(Request $request){
        if(!empty($request->id)){
            $id = $request->id;
            $categories = Categories::where('product_categories.id',$id)
                    ->select('product_categories.id as id','product_categories.category_name as category_name','product_subcategories.subcategory_name as subcategory_name','product_categories.created_at as created_at')
                    ->join('product_subcategories','product_categories.id','=','product_subcategories.parent_category_id')
                    ->get();

            $category =json_decode(json_encode($categories), true);

            return view("admin.items.form",compact(
                'categories','category'
            ));

        }else{
            return view("admin.items.form");
        }
       
        
    }

    public function post(Request $request){
        $input = $request->only($this->formItems);
		
        $validator = Validator::make($request->all(), [
            "category_name" => ['required','string','max:20'],
            "subcategory_name_1" => ['nullable','string','max:20'],
            "subcategory_name_2" => ['nullable','string','max:20'],
            "subcategory_name_3" => ['nullable','string','max:20'],
            "subcategory_name_4" => ['nullable','string','max:20'],
            "subcategory_name_5" => ['nullable','string','max:20'],
            "subcategory_name_6" => ['nullable','string','max:20'],
            "subcategory_name_7" => ['nullable','string','max:20'],
            "subcategory_name_8" => ['nullable','string','max:20'],
            "subcategory_name_9" => ['nullable','string','max:20'],
            "subcategory_name_10" => ['nullable','string','max:20'],
            "subcategory_names" => ['required_without_all:subcategory_name_1,subcategory_name_2,subcategory_name_3,subcategory_name_4,subcategory_name_5,subcategory_name_6,subcategory_name_7,subcategory_name_8,subcategory_name_9,subcategory_name_10'],
        ]);

        if(!empty($request->id)){
            if($validator->fails()){
                return redirect()->action("Admin\ItemsController@show",['id'=>$request->id])
                    ->withInput()
                    ->withErrors($validator);
            } 
        }else{
            if($validator->fails()){
                return redirect()->action("Admin\ItemsController@show")
                    ->withInput()
                    ->withErrors($validator);
            }
        }

		//セッションに書き込む
		$request->session()->put("form_input", $input);
        //form_inputというキーでフォームの入力値を保存

		return redirect()->action("Admin\ItemsController@confirm");
        //confirm()関数のルーティングにリダイレクトします。この書き方で「/form/confirm」にリダイレクトします。
    }

    public function confirm(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("Admin\ItemsController@show");
		}
		return view("admin.items.form_confirm",["input" => $input]);
        
    }

    public function send(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("Admin\ItemsController@show");
		}


        if(empty($input['id'])){
            Categories::all(); 

            \DB::beginTransaction();
            try{
                
                $category = new Categories;
    
                $category->category_name = $input["category_name"];
    
                $category->save();
                \DB::commit();

            }catch(\Throwable $e){
                \DB::rollback();
                abort(500); //500エラーを表示する。
            }

            $category_id = Categories::where('category_name',$input["category_name"])->first();

            SubCategories::all(); 

            if(!empty($input["subcategory_name_1"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_1"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_2"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_2"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_3"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_3"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_4"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_4"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_5"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_5"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_6"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_6"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_7"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_7"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_8"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_8"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_9"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_9"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_10"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_10"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }
            
        }elseif(!empty($input['id'])){

            //大カテゴリを変更
            $category = Categories::where('id',$input['id'])->first();
            $category->category_name = $input["category_name"];
            $category->save();

            //小カテゴリ削除
            $subcategory_delete = SubCategories::where('parent_category_id',$input["id"])->first();
            $subcategory_delete->delete();

            //新たに小カテゴリいれる。
            $category_id = Categories::where('id',$input['id'])->first();

            SubCategories::all(); 

            if(!empty($input["subcategory_name_1"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_1"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_2"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_2"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_3"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_3"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_4"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_4"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_5"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_5"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_6"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_6"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_7"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_7"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_8"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_8"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }


            if(!empty($input["subcategory_name_9"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_9"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }

            if(!empty($input["subcategory_name_10"])){
                \DB::beginTransaction();
                try{
    
                    $subcategory = new SubCategories;
                    $subcategory->parent_category_id = $category_id->id;
                    $subcategory->subcategory_name = $input["subcategory_name_10"];
        
                    $subcategory->save();
                    \DB::commit();
                }catch(\Throwable $e){
                    \DB::rollback();
                    abort(500); //500エラーを表示する。
                }
            }
        }
        

		// 二重送信対策(2021080415:51)
		//参考 https://www.bnote.net/blog/laravel_double_submit.html
        $request->session()->regenerateToken();
		
		//セッションを空にする
		$request->session()->forget("form_input");

		return redirect()->action("Admin\ItemsController@category");

    }
}
