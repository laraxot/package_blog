<?php



namespace XRA\Blog\Controllers\Admin\blog\post;

use App\Http\Controllers\Controller;
//--- extends ---
use XRA\Blog\Models\Post;
//--- Models ---//
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class OrderController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new Post();
    }
}
