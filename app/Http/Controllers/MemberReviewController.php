<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reviews;
use App\Models\items;
use Validator;

class MemberReviewController extends Controller
{
    public function all(Request $request){
        $id = $request->id;
        $reviews = reviews::where('reviews.member_id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->select('reviews.id as reviews_id','products.id as products_id','products.imege_1 as imege_1','products.product_subcategory_id as product_subcategory_id','products.name as name','reviews.evaluation as evaluation','reviews.comment as comment')
                ->orderBy('reviews.id', 'desc')
                ->paginate(5);


        return view("member.review.all",compact(
            'reviews'
        ));
    }

    public function show(Request $request){
        $id = $request->id;
        $items = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->get();

        $items->evaluation = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->avg('reviews.evaluation');

        return view("member.review.edit",compact(
            'items','id'
        ));
    }

    public function edit(Request $request){

        $input = $request->only("comment","evaluation","product_id","review_id");
        $validator = Validator::make($request->all(), [
			"comment" => ['required','string','max:500'],
			"evaluation" => ['required','in:1,2,3,4,5'],
		]);
        if($validator->fails()){
			return redirect()->action("MemberReviewController@show",['id'=>$input["review_id"]])
				->withInput()
				->withErrors($validator);
		}

        $request->session()->put("form_input", $input);

        return redirect()->action("MemberReviewController@confirm");

    }

    public function confirm(Request $request){
        $input = $request->session()->get("form_input");

        $items = reviews::where('reviews.product_id',$input["product_id"])
                ->join('products','reviews.product_id','=','products.id')
                ->get();

        $items->evaluation = reviews::where('reviews.product_id',$input["product_id"])
                ->join('products','reviews.product_id','=','products.id')
                ->avg('reviews.evaluation');

        
        if(!$input){
			return redirect()->action("MemberReviewController@show");
		}
		return view("member.review.confirm",compact(
            'items','input'
        ));
    }

    public function send(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("MemberReviewController@show");
		}

        $reviews = reviews::where('id',$input["review_id"])->first();
        $reviews->evaluation = $input["evaluation"];
        $reviews->comment = $input["comment"];
        $reviews->save();

        //セッションを空にする
		$request->session()->forget("form_input");
        
        return redirect()->action("MemberReviewController@all",['id'=>$reviews->member_id]);
    }

    public function view(Request $request){
        $id = $request->id;
        $items = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->get();

        $items->evaluation = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->avg('reviews.evaluation');

        return view("member.review.delete",compact(
            'items','id'
        ));
    }

    public function delete(Request $request){
        if($request->review_id){
            $reviews = reviews::find($request->review_id);
            $reviews->delete();
            return redirect()->action("MemberReviewController@all",['id'=>$reviews->member_id]);
        }
    }
}
