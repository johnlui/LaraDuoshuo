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
  return '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>403</title></head><body><h3>没有鱼丸，没有粗面</h3></body></html>';
});

Route::group(['middleware' => 'jsonp'], function() {
  Route::get('get-uuid', 'ArticleController@getUUID');
  Route::get('get-comments-by-uuid', 'CommentController@getCommentsByUUID');
  Route::get('add-comments-by-uuid', 'CommentController@addCommentsByUUID');
});