<?php



namespace XRA\Blog\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Post;
//------- services
use XRA\Extend\Services\ThemeService;

class CategoryController extends Controller
{
    public function show(Request $request)
    {
        //$this->authorize('view', $post);
        //return view('blog::posts.show', ['post' => $post]);
        $params = \Route::current()->parameters();
        $row = Post::where('guid', $params['guid_category'])->first();

        return ThemeService::addViewParam('row', $row)->view();
    }
}
