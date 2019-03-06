<?php



namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelated;
//use XRA\Extend\Traits\ArtisanTrait;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\FrontTrait as FrontTrait;

class SitemapController extends Controller
{
    use FrontTrait;

    public $time_start = null;

    public function delta()
    {
        if (null == $this->time_start) {
            $this->time_start = \microtime(true);
        }
        $back = \debug_backtrace();
        //dd($back);
        echo '<br/>['.$back[0]['line'].'] memory_get_usage :'.\round(\memory_get_usage() / (1024 * 1024), 2).'  time :'.\round(\microtime(true) - $this->time_start, 2);
        $this->time_start = \microtime(true);
    }

    public function index(Request $request)
    {
        \Debugbar::disable();
        $params = \Route::current()->parameters();
        $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
        //dd(config('app.url'));//sarebbe da settare questo
        $sitemap_path = public_path('sitemap.xml');
        //$e=SitemapGenerator::create($url)->writeToFile($sitemap_path);
        //echo '<br/>['.__LINE__.'] memory_get_usage :'.round(memory_get_usage()/(1024*1024),2);
        //$rows=Post::where('lang','it')->where('title','!=','')->ofParentId(0)->get();
        PostRelated::whereRaw('post_id=related_id')->delete();
        $lang = \App::getLocale();
        //$row=Post::where('lang',$lang)->whereRaw('guid = type')->where('type','sitemap')->first();
        $row = Post::firstOrCreate(['lang' => $lang, 'type' => 'sitemap', 'guid' => 'sitemap'], ['title' => 'sitemap']);
        $models = config('xra.model');
        foreach ($models as $k => $v) {
            $m = Post::firstOrCreate(['lang' => $lang, 'type' => 'sitemap', 'guid' => $k], ['title' => $k]);
        }

        //ddd($row->archive);
        $view = 'blog::sitemap.index';
        $out = view($view)->with('row', $row)->with('lang', $lang);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.\chr(13).(string) $out;

        return response($xml)->header('Content-Type', 'text/xml'); // application/rss+xml
    }

    public function show(Request $request)
    {
        $params = \Route::current()->parameters();
        \extract($params);
        $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
        PostRelated::whereRaw('post_id=related_id')->delete();
        $lang = \App::getLocale();
        $type=is_object($item0)?$item0->type:$item0;
        $roots=array_keys(config('xra.model'));
        if(!in_array($type,$roots)){
            return abort(404);
        }
        $root = Post::firstOrCreate(['lang' => $lang, 'type' => $type, 'guid' => $type], ['title' => $type]);

        $locale = config('laravellocalization.supportedLocales.'.$lang);
        //$view=CrudTrait::getView($params); //special case, so i write view path
        $view = 'blog::sitemap.show';
        $out = view($view)
                    ->with('lang', $lang)
                    ->with('locale', $locale)
                    ->with('root', $root)
                    ->with('params', $params)
                    ->with($params)
                    ;
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.\chr(13).(string) $out;

        return response($xml)->header('Content-Type', 'text/xml'); // application/rss+xml
    }
}//end class
