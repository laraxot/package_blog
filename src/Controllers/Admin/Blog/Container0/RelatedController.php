<?php



namespace XRA\Blog\Controllers\Admin\Blog\Container0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- extends ---
//--- services
use XRA\Extend\Services\ThemeService;

//--- Models ---//

//use XRA\Blog\Models\PostRev;

class RelatedController extends Controller
{
    public function index(Request $request)
    {
        $lang = \App::getlocale();
        $params = \Route::current()->parameters();
        $row = last($params);
        \extract($params);

        return ThemeService::addViewParam('row', $row)->view();
    }
}
