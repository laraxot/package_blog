<?php

namespace XRA\Blog\Controllers\container;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//------  models -----------
use \XRA\Blog\Models\Post;

class CatController extends Controller{

	public function index(Request $request){
        if ($request->routelist == 1) {
            return ArtisanTrait::exe('route:list');
        }
        $params = \Route::current()->parameters();
        $model=config('xra.model.'.$params['container']);
        $controller=str_replace('\\Models\\','\\Controllers\\',$model).'CatController';
        return app($controller)->index($request);
    }

}