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
Route::get('/item', "ItemFormController@show")->name("item.show")->middleware('auth');;

// item 遷移先
Route::post('/item', "ItemFormController@post")->name("item.post");

// item 確認画面
Route::get('/item/confirm', "ItemFormController@confirm")->name("item.confirm");
// item 確認画面からフォーム遷移先
Route::post('/item/confirm', "ItemFormController@send")->name("item.send");

Route::get('/', "ItemFormController@complete")->name("item.complete");

//セレクトボックス用
Route::post('/fetch/category', 'PostController@fetch')->name('post.fetch');
//セレクトボックス用
Route::post('/fetch/image', 'PostController@image')->name('post.image');