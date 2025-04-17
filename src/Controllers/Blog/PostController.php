<?php



namespace XRA\Blog\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Blog\Models\Post;
//--- services --
use XRA\Extend\Services\ThemeService;

class PostController extends Controller
{
    public function show(Request $request)
    {
        //$this->authorize('view', $post);
        //return view('blog::posts.show', ['post' => $post]);
        $params = \Route::current()->parameters();
        //$row=PostRev::where('guid', $params['guid_post'])->first();
        $row = Post::where('guid', $params['guid_post'])->first();

        return ThemeService::addViewParam('row', $row)->view();
    }
}//end class

/*
 <pre class="prettyprint lang-php"></p>

 */
