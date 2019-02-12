<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//------traits -----
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;
//-------services--------
use XRA\Extend\Services\ThemeService;
//-------models----------
use XRA\Blog\Models\Post;

class HomeController extends Controller
{

    public $cache = 0;
    //use CrudTrait;
    public function index(Request $request)
    {
        if (1 == $request->migrate) {
            config(['app.APP_ENV' => 'local']);

            return ArtisanTrait::exe('migrate');
        }
        if (1 == $request->routelist) {
            return ArtisanTrait::exe('route:list');
        }

        /*
        $roots = Post::getRoots();
        $row = $roots['home'];
        ThemeService::setMetatags($row);

        return ThemeService::view()->with($roots)->with('row', $row);
        */
        $cache_key=str_slug(__CLASS__.__FUNCTION__);
        if(\Auth::check()){
            $cache_key.='_'.\Auth::user()->handle;
        }
        $cache_key.='_2'; //force refresh
        $view = \Cache::store('file')->remember($cache_key,$this->cache,function () use($request){
            //return $this->showTrait($request)->render();
            $roots = Post::getRoots();
            $row = $roots['home'];
            ThemeService::setMetatags($row);

            return ThemeService::view()->with($roots)->with('row', $row)->render();
        });
        return $view;


    }

    /*
    public function indexOLD(Request $request)
    {
        $lang=\App::getLocale();
        $params = \Route::current()->parameters();
        if ($request->routelist==1) {
            return ArtisanTrait::exe('route:list');
        }
        if ($request->migrate==1) {
            config(['app.APP_ENV' => 'local']);
            return ArtisanTrait::exe('migrate');
        }
        if ($request->test==666) {
            return ArtisanTrait::exe('make:notification',['name'=>'MyFirstNotification']);
        }
        if ($request->clearcache==1 || $request->force==1) {
            \Cache::flush();
        }
        return ThemeService::view();
        extract($params);
        $roots=Post::getRoots();
        //$view = CrudTrait::getView($params);
        $view='pub_theme::index';
        return view($view)
                ->with('view', $view)
                ->with('lang', $lang)
                ->with('row', $roots['home'])
                ->with('params', $params)   //for route
                ->with($params)
                ->with($roots);
    }
    */
}
