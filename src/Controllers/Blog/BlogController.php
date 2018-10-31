<?php
namespace XRA\Blog\Controllers\Blog;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
//--------models-----------
use XRA\Blog\Models\Blog;
use XRA\Blog\Models\Post;
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

class BlogController extends Controller
{
    /*
    public function index(Request $request){
        if ($request->routelist == 1) {
            return ArtisanTrait::exe('route:list');
        }
        $rows=Post::all();
        $view=CrudTrait::getView();
        return view($view)->with('rows',$rows);
    }

    public function show(Request $request){
        //$this->authorize('view', $post);
        //return view('blog::posts.show', ['post' => $post]);
        $params = \Route::current()->parameters();
        $row=Post::where('guid',$params['guid_post'])->first();
        $view=CrudTrait::getView();
        return view($view)->with('row',$row);

    }
    */
    public function show(Request $request)
    {
        if ($request->routelist == 1) {
            return ArtisanTrait::exe('route:list');
        }
        $rows=Post::all();
        $view=CrudTrait::getView();
        return view($view)->with('rows', $rows);
    }
}
