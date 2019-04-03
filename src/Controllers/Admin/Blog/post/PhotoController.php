<?php



namespace XRA\Blog\Controllers\Admin\blog\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- extends ---
use XRA\Blog\Models\Post;
//--- services
use XRA\Extend\Services\ThemeService;
//--- Models ---//
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class PhotoController extends Controller
{
    use CrudTrait{
        store as protected storeTrait;
    }

    public function getModel()
    {
        return new Post();
    }

    public function index(Request $request)
    {
        $params = \Route::current()->parameters();
        \extract($params);
        if (isset($lang)) {
            \App::setlocale($lang);
        } //?

        \DB::update('update blog_posts set post_id=id where post_id=0');

        $row = Post::where('post_id', $id_post)->where('lang', $lang)->first();
        $rows = $row->related('photo')->orderBy('pivot_pos');

        return ThemeService::addViewParam('row', $row)->view();
    }

    public function store(Request $request)
    {
        $params = \Route::current()->parameters();
        \extract($params);
        $row = Post::where('post_id', $id_post)->where('lang', $lang)->first();
        $request->_out = 'model';
        $row_new = $this->storeTrait($request);
        $row_new->post_id = $row_new->id;
        $row_new->save();
        //echo '<h3>'.$row_new->post_id.'</h3>';
        $row->related()->attach($row_new->post_id, ['type' => 'photo']);
    }
}
