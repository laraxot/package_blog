<?php



namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- extends ---
use XRA\Blog\Models\Post;
//-------models---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class BlogController extends Controller
{
    use CrudTrait{
        index as protected indexTrait;
    }

    public function index(Request $request)
    {
        $lang = \App::getLocale();
        $params = \Route::current()->parameters();
        \extract($params);
        //--- creazione contenitori se non esistono
        foreach (config('xra.model') as $k => $v) {
            Post::firstOrCreate(['lang' => $lang, 'type' => $k, 'guid' => $k], ['title' => $k]);
        }

        return $this->indexTrait($request);
    }

    //end index

    public function component(Request $request)
    {
        $data = $request->all();
        \extract($data);
        if (!isset($content_type)) {
            $content_type = 'html';
        } //only 4 test
        if (!isset($content)) {
            $data['content'] = 'content not passed';
        } //only 4 test

        return view('backend::includes.ajax.'.$content_type)->with('row', $data);
    }
}
