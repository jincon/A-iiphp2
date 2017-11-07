<?php
/**
 * Created by PhpStorm.
 * User: jincon
 * Date: 2016/12/27
 * Time: 上午8:49
 */

use TinyLara\TinyRouter\TinyRouter as Route;


Route::get('/', 'HomeController@home');
Route::get('houtai/admin', 'AdminController@home',['namespace'=>'houtai']);
Route::get('article/show/(:num)/(:num)', 'ArticleController@show');  //单单只支持get
Route::any('article/show/(:num)/(:num)', 'ArticleController@show');  //支持get和post两种。
Route::get('view/(:num)/(:num)/(:any)', 'ArticleController@view');

//Route::get('/', function() {
//    echo "hello world！";
//});

Route::get('fuck', function() {
    echo "成功！";
});

Route::get('(:all)', function($fu) {
    echo '未匹配到路由<br>'.$fu;
});

Route::$error_callback = function() {

    throw new Exception("路由无匹配项 404 Not Found");

};


Route::dispatch();