<?php



namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Post;
//use XRA\Extend\Traits\FrontTrait as FrontTrait;
//use XRA\Extend\Traits\ArtisanTrait;

use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class FeedController extends Controller
{
    use CrudTrait;

    public function index(Request $request)
    {
        $params = \Route::current()->parameters();
        //$view=CrudTrait::getView($params);
        $view = 'blog::feed.index';
        $lang = \App::getLocale();
        //$locale=config('laravellocalization.supportedLocales.'.$lang);
        $rows = Post::where('lang', $lang)
                ->orderBy('updated_at')->paginate(10);
        //-- populating
        $type = 'feed';
        $row = Post::firstOrCreate(['lang' => $lang, 'type' => $type, 'guid' => $type], ['title' => $type]);
        $models = config('xra.model');
        foreach ($models as $k => $v) {
            $m = Post::firstOrCreate(['lang' => $lang, 'type' => $type, 'guid' => $k], ['title' => $k]);
        }
        //----
        $feed = (string) view($view)
                ->with('lang', $lang)
                //->with('locale',$locale)
                ->with('rows', $rows)
                ->with('params', $params)
                ->with($params)
                ;
        $feed = '<?xml version="1.0" encoding="UTF-8"?>'.$feed;

        return response($feed)->header('Content-Type', 'text/xml'); // application/rss+xml
    }

    //*
    public function show(Request $request)
    {
        $params = \Route::current()->parameters();
        \extract($params);
        $view = 'blog::feed.show';
        $lang = \App::getLocale();
        //item e' un elemento di tipo feed
        //ddd($item->archive()->orderBy('updated_at','desc')->limit(10)->get());
        $type=is_object($item0)?$item0->type:$item0;
        $rows = Post::where('lang', $lang)
                ->where('type', '=', $type)
                ->orderBy('updated_at', 'desc')->paginate(10);

        $feed = view($view)
                ->with('lang', $lang)
                ->with('rows', $rows)
                ->with('params', $params)
                ->with($params)
                ;
        $feed = '<?xml version="1.0" encoding="UTF-8"?>'.(string) $feed;

        return response($feed)->header('Content-Type', 'text/xml'); // application/rss+xml
    }

    //*/
}//end class
