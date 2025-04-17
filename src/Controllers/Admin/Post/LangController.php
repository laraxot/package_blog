<?php



namespace XRA\Blog\Controllers\Admin\post;

use App\Http\Controllers\Controller;
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

//--- Models ---//

class LangController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new \XRA\Blog\Models\Post();
    }
}
