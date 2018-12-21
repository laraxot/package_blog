<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
//--------models-----------
use XRA\Blog\Models\Blog;
use XRA\Blog\Models\Post;
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;
//--- services --
use XRA\Extend\Services\ThemeService;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->routelist == 1) {
            return ArtisanTrait::exe('route:list');
        }
        $rows=Post::all();
        return ThemeService::addViewParam('rows', $rows)->view();
    }

    public function show(Request $request)
    {
        //$this->authorize('view', $post);
        //return view('blog::posts.show', ['post' => $post]);
        $params = \Route::current()->parameters();
        $row=Post::where('guid', $params['guid_post'])->first();
        return ThemeService::addViewParam('row', $row)->view();
    }
}
