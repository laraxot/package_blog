<?php



namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- extends ---
use XRA\Blog\Models\Post;
//--- services
use XRA\Blog\Models\PostRelated;
//--- Models ---//
use XRA\Extend\Services\ThemeService;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

//use XRA\Blog\Models\PostRev;

class RelatedController extends Controller
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
        /*
        $duplicateRecords = \DB::select('id','post_id','related_id','type')
              ->selectRaw('count(`*`) as `occurences`')
              ->from('blog_post_related')
              ->groupBy('post_id','related_id','type')
              ->having('occurences', '>', 1)
              ->get();
        //*/

        $duplicateRecords = PostRelated::selectRaw('post_id,related_id,type,count(*) as `occurences`')
            ->groupBy('post_id', 'related_id', 'type')
            ->having('occurences', '>', 1)
            ;
        foreach ($duplicateRecords->get() as $row) {
            PostRelated::where('post_id', $row->post_id)
                ->where('related_id', $row->related_id)
                ->where('type', $row->post_type)
                ->limit($row->occurences - 1)
                ->delete();
        }

        /*
        $row=Post::where('post_id',$id_post)->where('lang',$lang)->first();
        if($row==null){
            $row_master=Post::where('post_id',$id_post)->where('lang','it')->first();
            $row = $row_master->replicate();
            $row->lang=$lang;
            $row->save();
        }
        */
        //$row=PostRev::where('id', $id_post)->first();
        $row = Post::where('id', $id_post)->first();
        //dd($row);
        $rows = $row->related()->orderBy('pivot_pos');

        return ThemeService::addViewParam('row', $row)->addViewParam('allrows', $rows)->view();
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
        $row->related()->attach($row_new->post_id, ['type' => $row->post_type.'_x_'.$row_new->post_type]);

        return redirect()->back();
    }

    public function attach(Request $request)
    {
        $params = \Route::current()->parameters();
        //dd($params);

        \extract($params);
        //$row=PostRev::where('id', $id_post)->where('lang', $lang)->first();
        $row = Post::where('id', $id_post)->where('lang', $lang)->first();
        //dd($request->all());
        if ('PUT' == $request->_method) {
            //dd('aa');
            $row->related()->attach($request->post_id, ['type' => $request->post_type]);

            return redirect()->route('blog.post.related.index', $params); //response()->back();
        }

        return ThemeService::addViewParam('row', $row)->view();
    }

    public function deattach(Request $request)
    {
        $params = \Route::current()->parameters();
        \extract($params);
        $row = Post::where('post_id', $id_post)->where('lang', $lang)->first();
        $row->related()->detach($id_related);
        //return redirect()->route('blog.post.related.index',$params); //response()->back();
        return redirect()->back();
    }
}
