<?php



namespace XRA\Blog\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--------models-----------
use XRA\Blog\Models\Post;
//--- extends ---
use XRA\Extend\Services\ThemeService;
//--- services
use XRA\Extend\Traits\ArtisanTrait;

class BlogController extends Controller
{
    public function show(Request $request)
    {
        if ($request->act=='routelist') {
            return ArtisanTrait::exe('route:list');
        }
        $rows = Post::all();

        return ThemeService::addViewParam('rows', $rows)->view();
    }
}
