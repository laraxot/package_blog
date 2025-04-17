<?php



namespace XRA\Blog\Controllers\Api\container;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Post;
use XRA\Extend\Traits\ArtisanTrait;
//------  models -----------
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class SearchController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new Post();
    }

    public function index(Request $request)
    {
        $params = \Route::current()->parameters();
        $params = \array_merge($params, $request->all());
        \extract($params);
        if (\is_object($container)) {
            $container_type = $container0->post_type;
        } else {
            $container_type = $container;
        }
        $model = config('xra.model.'.$container_type);
        $controller = \str_replace('\\Models\\', '\\Controllers\\Api\\', $model).'Controller'; //XRA\Food\Controllers\Api\RestaurantController
        return app($controller)->index($request);
    }

    public function show(Request $request)
    {
        die('show');
        if ($request->act=='routelist') {
            return ArtisanTrait::exe('route:list');
        }
        $params = \Route::current()->parameters();
        $model = config('xra.model.'.$params['container']);
        $controller = \str_replace('\\Models\\', '\\Controllers\\Api\\', $model).'Controller';

        return app($controller)->show($request);
    }
}//end class
