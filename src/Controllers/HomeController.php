<?php



namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//------traits -----
use XRA\Blog\Models\Post;
use XRA\Extend\Services\ThemeService;
//-------services--------
use XRA\Extend\Traits\ArtisanTrait;
//-------models----------
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class HomeController extends Controller
{
    //use CrudTrait;
    public function index(Request $request)
    {
        if (1 == $request->migrate) {
            config(['app.APP_ENV' => 'local']);

            return ArtisanTrait::exe('migrate');
        }
        $roots = Post::getRoots();
        $row = $roots['home'];
        ThemeService::setMetatags($row);

        return ThemeService::view()->with($roots)->with('row', $row);
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
