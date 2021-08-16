<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ・get 問い合わせフォームを表示
Route::get('/form', "SampleFormController@show")->name("form.show");
// ・post 問い合わせフォーム遷移先
Route::post('/form', "SampleFormController@post")->name("form.post");

// ・get 確認画面
Route::get('/form/confirm', "SampleFormController@confirm")->name("form.confirm");
// ・post 確認画面からフォーム遷移先
Route::post('/form/confirm', "SampleFormController@send")->name("form.send");

// ・get 完了画面
Route::get('/form/thanks', "SampleFormController@complete")->name("form.complete");


Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

// item 表示
Route::get('/item', "ItemFormController@show")->name("item.show")->middleware('auth');

// item 遷移先
Route::post('/item', "ItemFormController@post")->name("item.post");

// item 確認画面
Route::get('/item/confirm', "ItemFormController@confirm")->name("item.confirm");
// item 確認画面からフォーム遷移先
Route::post('/item/confirm', "ItemFormController@send")->name("item.send");

//セレクトボックス用
Route::post('/fetch/category', 'PostController@fetch')->name('post.fetch');
//セレクトボックス用
Route::post('/fetch/image', 'PostController@image')->name('post.image');


// item 一覧表示
Route::get('/item/all', "ItemAllController@show")->name("itemall.show");

// item 詳細表示
Route::get('/item/all/detail', "ItemAllController@detail")->name("itemall.detail");

// item レビュー表示
Route::get('/item/all/detail/review', "ItemAllController@review")->name("itemall.review")->middleware('auth');

// item レビュー遷移先
Route::post('/item/all/detail/review', "ItemAllController@post")->name("itemall.post");

// item レビュー確認画面
Route::get('/item/all/detail/review/confirm', "ItemAllController@confirm")->name("itemall.confirm");

// item レビュー確認画面からフォーム遷移先
Route::post('/item/all/detail/review/confirm', "ItemAllController@send")->name("itemall.send");
// item レビュー 完了画面
Route::get('/item/all/detail/review/thanks', "ItemAllController@complete")->name("itemall.complete");

// item レビューすべて
Route::get('/item/all/detail/review_show', "ItemAllController@reviewall")->name("itemall.reviewall");


// マイページ詳細
Route::get('/member/detail', "MemberController@show")->name("member.show");