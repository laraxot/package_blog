<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//------traits -----
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;
//use XRA\Extend\Traits\ArtisanTrait;
//-------services--------
use XRA\Extend\Services\ThemeService;
use XRA\Extend\Services\TranslatorService;
use XRA\Extend\Services\ArtisanService;

//-------models----------
use XRA\Blog\Models\Post;

class HomeController extends Controller
{

    public $cache = 0;
    public $cache_time = 60*26*24;
    //use CrudTrait;
    public function index(Request $request)
    {
        $out=ArtisanService::act($request->act);
        if($out!='') return $out;
        
        if ($request->act=='translate') { //retrocomp, fra poco cancellare
            return ThemeService::view('extend::translate');
        }
        $cache_key=str_slug(url()->current());
        if(\Auth::check()){
            $cache_key.='_'.\Auth::user()->handle;
        }
        $out = \Cache::remember($cache_key,$this->cache_time,function () use($request){
            $roots = Post::getRoots();
            $out= ThemeService::view()->with($roots)->render();
            return $out;
        });
        return $out;
        //$out=(string)$out;
        //3.8
        /*
        $row = $roots['home'];
        ThemeService::setMetatags($row);

        return ThemeService::view()->with($roots)->with('row', $row);
        */
        /*
        $lang=\App::getLocale();
        $cache_key=str_slug(__CLASS__.__FUNCTION__);
        if(\Auth::check()){
            $cache_key.='_'.\Auth::user()->handle;
        }
        $cache_key.='_'.$lang.'_2'; //force refresh
        $view = \Cache::remember($cache_key,$this->cache,function () use($request){
            //return $this->showTrait($request)->render();
            $roots = Post::getRoots();
            $row = $roots['home'];
            ThemeService::setMetatags($row);

            return ThemeService::view()->with($roots)->with('row', $row)->render();
        });
        return $view;
        */
    
    }

    /*
    public function indexOLD(Request $request)
    {
        $lang=\App::getLocale();
        $params = \Route::current()->parameters();
        if ($request->act=='routelist') {
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

    public function redirect(Request $request){
        return redirect($request->url);
    }


    public function store(Request $request){
        $data=$request->all();
        $trans=$data['trans'];
        foreach($trans as $k=>$v){
            TranslatorService::set($k, $v);
        }
         if (\Request::ajax()) {
                $response = [
                    'success' => true,
                    //'data'    => $result,
                    'message' => 'OK',
                ];
                $response = \array_merge($data, $response);

                return response()->json($response, 200);
        }
        return redirect()->back();
        
    }
}
