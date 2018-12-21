<?php
namespace XRA\Blog\Controllers\Admin\Blog\Container0;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
 
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;
//--- services
use XRA\Extend\Services\ThemeService;

//--- Models ---//
use XRA\Blog\Models\PostContent;
use XRA\Blog\Models\PostRelated;
use XRA\Blog\Models\Post;

//use XRA\Blog\Models\PostRev;

class RelatedController extends Controller
{
    public function index(Request $request)
    {
        $lang=\App::getlocale();
        $params = \Route::current()->parameters();
        $row=last($params);
        extract($params);
        return ThemeService::addViewParam('row', $row)->view();
    }
}
