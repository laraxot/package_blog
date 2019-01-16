<?php



namespace XRA\Blog\Controllers\Container0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Extend\Traits\ArtisanTrait;

//------  models -----------

class CatController extends Controller
{
    public function index(Request $request)
    {
        if (1 == $request->routelist) {
            return ArtisanTrait::exe('route:list');
        }
        $params = \Route::current()->parameters();
        $model = config('xra.model.'.$params['container']);
        $controller = \str_replace('\\Models\\', '\\Controllers\\', $model).'CatController';

        return app($controller)->index($request);
    }
}
