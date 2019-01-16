<?php



namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

//--- Models ---//

//use XRA\Blog\Models\PostRev;

class RelatedRevController extends Controller
{
    use CrudTrait{
        store as protected storeTrait;
    }
}
