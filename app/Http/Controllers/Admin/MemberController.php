<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    function all(Request $request){

        //検索機能
        $member_id = $request->input('member_id');
        $gender = $request->input('gender');
        $free_word = $request->input('free_word');

        if(!empty($member_id) && !empty($gender) && !empty($free_word)){
            $query = User::where('id',$member_id)
                    ->where('gender',$gender)
                    ->where(function($query)use ($free_word){
                        $query->where('name_sei','like','%'.$free_word .'%')
                    ->orWhere('name_mei','like','%'.$free_word.'%')
                    ->orWhere('email','like','%'.$free_word.'%');
                    });

        }elseif(!empty($member_id) && !empty($gender) && empty($free_word)){
            $query = User::where('id',$member_id)
                    ->where('gender',$gender);
        }elseif(!empty($member_id) && empty($gender) && !empty($free_word)){
            $query = User::where('id',$member_id)
                    ->where(function($query)use ($free_word){
                        $query->where('name_sei','like','%'.$free_word .'%')
                    ->orWhere('name_mei','like','%'.$free_word.'%')
                    ->orWhere('email','like','%'.$free_word.'%');
                    });
        }elseif(empty($member_id) && !empty($gender) && !empty($free_word)){
            $query = User::where('gender',$gender)
                    ->where(function($query)use ($free_word){
                        $query->where('name_sei','like','%'.$free_word .'%')
                    ->orWhere('name_mei','like','%'.$free_word.'%')
                    ->orWhere('email','like','%'.$free_word.'%');
                    });
        }else{
            //query作成
            $query = User::query();

            if(!empty($member_id)){
                $query->where('id',$member_id);
            }

            if(!empty($gender)){
                $query->where('gender',$gender);
            }

            //フリー ワード検索
            if(!empty($free_word)){
                $query->where('name_sei','like','%'.$free_word .'%')
                        ->orWhere('name_mei','like','%'.$free_word.'%')
                        ->orWhere('email','like','%'.$free_word.'%');
            }
        }

        if(!empty($request->sort)){
            $sort = $request->sort;
            $direction = $request->direction;
        }else{
            $sort = 'id';
            $direction = 'desc';
        }

        if($sort == "id" && $direction == "asc"){
            $members = $query->orderBy('id', 'asc')->sortable()->paginate(10);
        }elseif($sort == "id" && $direction == "desc"){
            $members = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "asc"){
            $members = $query->orderBy('created_at', 'asc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "desc"){
            $members = $query->orderBy('created_at', 'desc')->sortable()->paginate(10);
        }else{
            $members = $query->orderBy($id, 'desc')->sortable()->paginate(10);
        }
        
        return view('admin.members',compact(
            'members'
        ));
    }
}
