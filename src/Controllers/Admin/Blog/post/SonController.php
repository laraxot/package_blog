<?php
namespace XRA\Blog\Controllers\Admin\blog\post;

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
use XRA\Blog\Models\Post;

class SonController extends Controller
{
    use CrudTrait{
        store as protected storeTrait;
    }

    public function getModel()
    {
        return new Post;
    }
    public function index(Request $request)
    {
        $params = \Route::current()->parameters();
        extract($params);
        \DB::update('update blog_posts set post_id=id where post_id=0');

        $row=Post::where('post_id', $id_post)->where('lang', $lang)->first();
        $rows=$row->sons();
        return ThemeService::addViewParam('row', $row)->addViewParam('allrows', $rows)->view();
    }


    public function store(Request $request)
    {
        $params = \Route::current()->parameters();
        extract($params);
        $row=Post::where('post_id', $id_post)->where('lang', $lang)->first();
        $request->_out='model';
        $row_new=$this->storeTrait($request);
        $row_new->post_id=$row_new->id;
        $row_new->save();
        //echo '<h3>'.$row_new->post_id.'</h3>';
        $row->related()->attach($row_new->post_id, ['type'=>'photo']);
    }
}
