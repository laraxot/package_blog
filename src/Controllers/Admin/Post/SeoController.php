<?php



namespace XRA\Blog\Controllers\Admin\post;

use App\Http\Controllers\Controller;
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

//--- Models ---//

class SeoController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new \XRA\Blog\Models\Post();
    }

    public function getPrimaryKey()
    {
        return 'id_post';
    }
}
