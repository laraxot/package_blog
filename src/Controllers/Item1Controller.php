<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Post;
//-------models----------
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
//use XRA\Blog\Models\PostRev;
//------services---------
use XRA\Extend\Services\ThemeService;

class Item1Controller extends Controller
{
    public function getModel()
    {
        return new Post();
    }

    public function getController()
    {
        $params = \Route::current()->parameters();
        $model = config('xra.model.'.$params['container']);
        if ('' == $model) {
            $row = Post::where('lang', \App::getLocale())->where('guid', $params['container'])->first();
            $model = config('xra.model.'.$row->post_type);
            if ('' == $model) {
                die('<hr/>settare modello['.$row->post_type.'] in config/xra<hr/>'.'['.__LINE__.']['.__FILE__.']');
            }
        }
        $controller = \str_replace('\\Models\\', '\\Controllers\\', $model).'Controller';

        return $controller;
    }

    //use CrudTrait;
    public function show(Request $request)
    {
        $controller = $this->getController();

        return app($controller)->show($request);

        $params = \Route::current()->parameters();
        \extract($params);
        $containers = \array_keys(config('xra.model'));
        $lang = \App::getLocale();
        if (isset($item)) {
            $guid = $item;
            $func = 'show';
        } else {
            $guid = $container;
            $func = 'index';
        }

        //dd($params);
        //$row=Post::with(['related','parentPost'])->firstOrCreate(['lang'=>$lang,'guid'=>$guid,'type'=>$container],['title'=>$guid]);
        $row = Post::with([])->where('lang', $lang)->where('guid', $item)->where('type', $container)->first();
        $row1 = Post::with([])->where('lang', $lang)->where('guid', $item1)->where('type', $container1)->first();

        $rows = $row->linked->postRestaurants()->whereHas('related', function ($query) use ($row1) {
            $query->where('blog_post_related.related_id', $row1->post_id)->where('blog_post_related.type', 'restaurant_x_'.$row1->post_type);
        });

        $view = CrudTrait::getView($params);

        return view($view)->with('params', $params)
                        ->with('view', $view)
                        ->with('row', $row)
                        ->with('row1', $row1)
                        ->with('rows', $rows)
                        ;
        //dd($rows->get());
        //$ristos=Post::ofType('restaurant');
        //$ristos->post_type='restaurant';
        /*
        foreach($ristos->get() as $risto){
            echo '<hr/>';
            echo $risto->post_id.'<br/>';
            echo $risto->post_type.'<br/>';
            echo $risto->title.'<br/>';
        }

        echo '<h3>'.round(memory_get_usage()/1024,2).' KB </h3>';
        dd($ristos->get()[0]);
        die('['.__LINE__.']['.__FILE__.']');
        die('['.__LINE__.']['.__FILE__.']');
        */
        //dd($row);
        //dd($row->linked->listCuisineCats());
        /*
        $cuisineCats=$row->sons()->map(function($row){
            //return $row->relatedType('restaurant_x_cuisineCat')->get()->pluck('title','guid');
            return $row->related->where('pivot.type','location_x_cuisineCat');
        })->all();
        */
        //dd($cuisineCats);

        //dd($row->related('cuisineCat')->get());
    }

    //end show
}
