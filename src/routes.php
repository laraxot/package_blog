<?php

/*
//Route::get('timezones/{timezone}', 'xot\themes\ThemesController@index');
Route::group(['middleware' => ['web'],'namespace'=>'xot\blog'], function () {
	//Route::resource('/blog', 'BlogController');
	Route::get('/product/{id_grid}', 'xot\fpb\ProductController@preview')->name('product.preview');
	Route::get('/product/{id_grid}/thanks', 'xot\fpb\ProductController@thanks')->name('product.thanks');
	Route::get('/product/{id_grid}/pagamento', 'xot\fpb\ProductController@eseguiPagamento')->name('product.eseguiPagamento');
	Route::resource('/upload', 'xot\fpb\UploadController');
});
*/


Route::group(['middleware' => ['web'],'namespace'=>'xot\blog'], function () {
	Route::get('blogs', 'BlogController@index');
	Route::get('blogs/{page}', 'BlogController@show_blog_page');
	Route::get('blogs/{category}/page/{page}', 'BlogController@show_blog_category');
	Route::get('post/{id}', 'BlogController@show');
});
