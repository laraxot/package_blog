<?php
namespace XRA\Blog\Controllers\Admin\post;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
 
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//--- Models ---//
use XRA\Blog\Models\PostContent;

class SeoController extends Controller
{
    use CrudTrait;
    public function getModel()
    {
        return new \XRA\Blog\Models\Post;
    }
    public function getPrimaryKey()
    {
        return 'id_post';
    }
}
