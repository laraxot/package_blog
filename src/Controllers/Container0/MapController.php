<?php
namespace XRA\Blog\Controllers\Container0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//------  models -----------
//use \XRA\Blog\Models\Post;

class MapController extends Controller
{
    public function getController()
    {
        $params = \Route::current()->parameters();
        \extract($params);

        //dd($params);die;

        if (\is_object($container0)) {
            $type = $container0->type;
        } else {
            $type = $container0;
        }
        $model = config('xra.model.'.$type);
        if ('' == $model) {
            $row = Post::where('lang', \App::getLocale())->where('guid', $type)->first();
            $model = config('xra.model.'.$row->type);
            if ('' == $model) {
                die('<hr/>settare modello['.$row->type.'] in config/xra<hr/>'.'['.__LINE__.']['.__FILE__.']');
            }
        }
        $controller = \str_replace('\\Models\\', '\\Controllers\\', $model);
        if (isset($container1)) {
            if (\is_object($container1)) {
                $controller .= '\\'.\ucfirst($container1->type);
            } else {
                $controller .= '\\'.\ucfirst($container1);
            }
        }
        if (isset($container2)) {
            if (\is_object($container1)) {
                $controller .= '\\'.\ucfirst($container2->type);
            } else {
                $controller .= '\\'.\ucfirst($container2);
            }
        }
        $controller .= '\MapController';

        return $controller;
    }

    public function __call($method, $args)
    {
        $controller = $this->getController();

        return app($controller)->$method(Request::capture());
    }
}//end class
