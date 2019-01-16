<?php



namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--------models-----------
use XRA\Blog\Models\Blog;
use XRA\Blog\Models\Post;
//--- extends ---
use XRA\Extend\Services\ThemeService;
//--- services --
use XRA\Extend\Traits\ArtisanTrait;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if (1 == $request->routelist) {
            return ArtisanTrait::exe('route:list');
        }
        $rows = Post::all();

        return ThemeService::addViewParam('rows', $rows)->view();
    }

    public function show(Request $request)
    {
        //$this->authorize('view', $post);
        //return view('blog::posts.show', ['post' => $post]);
        $params = \Route::current()->parameters();
        $row = Post::where('guid', $params['guid_post'])->first();

        return ThemeService::addViewParam('row', $row)->view();
    }
}
