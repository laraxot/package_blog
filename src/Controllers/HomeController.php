<?php

namespace XRA\Blog\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//------traits -----
use XRA\Extend\Traits\ArtisanTrait;
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;
//-------models----------
use XRA\Blog\Models\Post;

class HomeController extends Controller{ 

	public function index(Request $request){
		$lang=\App::getLocale();
		$params = \Route::current()->parameters();
		if ($request->routelist==1) {
			return ArtisanTrait::exe('route:list');
		}
		if ($request->migrate==1) {
			config(['app.APP_ENV' => 'local']);
			return ArtisanTrait::exe('migrate');
		}
		if ($request->clearcache==1 || $request->force==1) {
			\Cache::flush();
		}
		extract($params);
		
		$roots=Post::getRoots();

		/*
		$roots['home']=$row;
		*/
		//$view = CrudTrait::getView($params);
		$view='pub_theme::index';
		return view($view)
				->with('view',$view)
				->with('lang',$lang)
				->with('row',$roots['home'])
				->with('params',$params)   //for route
				->with($params)
				->with($roots);
	}

}