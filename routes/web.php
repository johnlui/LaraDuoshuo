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

// 登录页面（GET）及登录登出请求（POST）
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

if(\Config::get('app.register_enable')){
  Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
  Route::post('register', 'Auth\RegisterController@register');
}
// 找回密码功能，已注释掉，如有需要请自行开启
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'jsonp'], function() {
  Route::get('get-uuid', 'ArticleController@getUUID');
  Route::get('get-comments-by-uuid', 'CommentController@getCommentsByUUID');
  Route::get('add-comments-by-uuid', 'CommentController@addCommentsByUUID');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
  Route::get('/', 'AdminController@index');
  Route::get('{id}/edit', 'AdminController@edit');
  Route::get('{id}/checked', 'AdminController@checked');
  Route::post('store', 'AdminController@store');
  Route::put('{id}', 'AdminController@update');
  Route::delete('{id}', 'AdminController@destroy');
});