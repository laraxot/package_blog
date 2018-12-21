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
//--- services
use XRA\Extend\Services\ThemeService;

class BlogController extends Controller
{
    public function show(Request $request)
    {
        if ($request->routelist == 1) {
            return ArtisanTrait::exe('route:list');
        }
        $rows=Post::all();
        return ThemeService::addViewParam('rows', $rows)->view();
    }
}
