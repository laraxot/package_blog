<?php



namespace XRA\Blog\Controllers\Container0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- traits ---
//--- services
use XRA\Extend\Services\ThemeService;

//--- Models ---//

//use XRA\Blog\Models\PostRev;

class RelatedController extends Controller
{
    public function index(Request $request)
    {
        $params = \Route::current()->parameters();
        $row = last($params);

        return ThemeService::addViewParam('row', $row)->view();
    }
}
