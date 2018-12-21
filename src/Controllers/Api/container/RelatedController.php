<?php
namespace XRA\Blog\Controllers\Api\container;

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
        $params = \Route::current()->parameters();
        $row=last($params);
        return ThemeService::addViewParam('row', $row)->view();
    }
}
