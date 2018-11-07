<?php
namespace XRA\Blog\Controllers\Admin\blog;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
 
//--- extends ---
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//--- Models ---//
use XRA\Blog\Models\PostContent;
use XRA\Blog\Models\PostRelated;
use XRA\Blog\Models\Post;
//use XRA\Blog\Models\PostRev;

class RelatedController extends Controller
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
        if (isset($lang)) {
            \App::setlocale($lang);
        } //?
        //echo '<pre>';print_r($params);echo '</pre>';
        //Post::where('post_id',0)->update(['post_id'=>'id']);
        //Post::statement();
        /*
        $rows1=Post::where('lang',$lang)->ofRelatedType('topbar');
        echo '<pre>';print_r($rows1->toSql()); echo '</pre>';
        echo '<pre>';print_r($rows1->get()->toArray()); echo '</pre>';
        dd('['.__LINE__.']['.__FILE__.']');
        */
    


        \DB::update('update blog_posts set post_id=id where post_id=0');
        /*
        $duplicateRecords = \DB::select('id','post_id','related_id','type')
              ->selectRaw('count(`*`) as `occurences`')
              ->from('blog_post_related')
              ->groupBy('post_id','related_id','type')
              ->having('occurences', '>', 1)
              ->get();
        //*/

        $duplicateRecords=PostRelated::selectRaw('post_id,related_id,type,count(*) as `occurences`')
            ->groupBy('post_id', 'related_id', 'type')
            ->having('occurences', '>', 1)
            ;
        foreach ($duplicateRecords->get() as $row) {
            PostRelated::where('post_id', $row->post_id)
                ->where('related_id', $row->related_id)
                ->where('type', $row->type)
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
        $row=Post::where('id', $id_post)->first();
        //dd($row);
        $rows=$row->related()->orderBy('pivot_pos');

        //$rows->get()->


        /*
        echo '<pre>';print_r($rows->toSql()); echo '</pre>';
        echo '<pre>';print_r($rows->get()->toArray()); echo '</pre>';
        dd('['.__LINE__.']['.__FILE__.']');
        */
        //dd($rows->toSql());
        $view=CrudTrait::getView();
        return view($view)->with('allrows', $rows)
            ->with('params', array_merge($request->all(), $params))
            ->with('row', $row);
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
        $row->related()->attach($row_new->post_id, ['type'=>$row->type.'_x_'.$row_new->type]);
        return redirect()->back();
    }

    public function attach(Request $request)
    {
        $params = \Route::current()->parameters();
        //dd($params);

        extract($params);
        //$row=PostRev::where('id', $id_post)->where('lang', $lang)->first();
        $row=Post::where('id', $id_post)->where('lang', $lang)->first();
        //dd($request->all());
        if ($request->_method=='PUT') {
            //dd('aa');
            $row->related()->attach($request->post_id, ['type'=>$request->type]);
            return redirect()->route('blog.post.related.index', $params); //response()->back();
        }
        $view=CrudTrait::getView();
        return view($view)->with('row', $row);
    }

    public function deattach(Request $request)
    {
        $params = \Route::current()->parameters();
        extract($params);
        $row=Post::where('post_id', $id_post)->where('lang', $lang)->first();
        $row->related()->detach($id_related);
        //return redirect()->route('blog.post.related.index',$params); //response()->back();
        return redirect()->back();
    }
}
