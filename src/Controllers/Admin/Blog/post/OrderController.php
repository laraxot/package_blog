<?php
namespace XRA\Blog\Controllers\Admin\blog\post;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
 
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//--- Models ---//
use XRA\Blog\Models\PostContent;
use XRA\Blog\Models\Post;

class OrderController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new Post;
    }
}
