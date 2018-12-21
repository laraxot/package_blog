<?php

namespace XRA\Blog\Controllers\Api\container;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//------  models -----------
use \XRA\Blog\Models\Post;

class SearchController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new Post;
    }
    public function index(Request $request)
    {
        $params = \Route::current()->parameters();
        $params=array_merge($params, $request->all());
        extract($params);
        if (is_object($container)) {
            $container_type=$container0->type;
        } else {
            $container_type=$container;
        }
        $model=config('xra.model.'.$container_type);
        $controller=str_replace('\\Models\\', '\\Controllers\\Api\\', $model).'Controller';//XRA\Food\Controllers\Api\RestaurantController
        return app($controller)->index($request);
    }

    public function show(Request $request)
    {
        die('show');
        if ($request->routelist == 1) {
            return ArtisanTrait::exe('route:list');
        }
        $params = \Route::current()->parameters();
        $model=config('xra.model.'.$params['container']);
        $controller=str_replace('\\Models\\', '\\Controllers\\Api\\', $model).'Controller';
        return app($controller)->show($request);
    }
}//end class
