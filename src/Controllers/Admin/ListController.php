<?php



namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- extends ---
use XRA\Blog\Models\Post;
//--- Models ---//
use XRA\Blog\Models\PostContent;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class ListController extends Controller
{
    use CrudTrait{
        edit as protected editTrait;
        store as protected storeTrait;
        update as protected updateTrait;
    }

    public function linkedFields($type)
    {
    }

    public function edit(Request $request)
    {
        $params = \Route::current()->parameters();
        \extract($params);
        //dd($params);
        $row = Post::find($id_post);
        //dd($row->type);
        return $this->editTrait($request);
    }

    public function store(Request $request)
    {
        $params = \Route::current()->parameters();

        if (\mb_strlen($request->guid) < 3) {
            $request->guid = str_slug($request->title);
            $request->request->set('guid', str_slug($request->title));
        }
        $request->_out = 'model';
        $row = $this->storeTrait($request);
        $row->post_id = $row->id;
        $res = $row->save();
        //echo '<h3>['.__LINE__.']['.__FILE__.']</h3>'; dd($row);
        $subrow = $row->linked->update($request->all());
        /* -- post content --
        $id_post=$row->post_id;
        $data = json_decode($request->post_content_serialized);
        foreach ($data as $el) {
            $el->post_id = $id_post;
            $request->request->add(get_object_vars($el));
            app(PostContentController::class)->store($request);
        }	*/

        \Session::flash('status', 'Aggiunto ! '.$row->type.' '.$row->id);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $params = \Route::current()->parameters();

        /*
        if(strlen($request->guid)<3){
            $request->guid=str_slug($request->title);
            $request->request->set('guid',str_slug($request->title));
        }
        */
        $request->_out = 'model';
        $row = $this->updateTrait($request);
        //$row->linked->address2='qqququ';
        //dd($row->linked);
        //if($row->linked==null){

        //}
        $subrow = $row->linked->update($request->all());
        //https://laravel.com/api/5.1/Illuminate/Database/Eloquent/Relations/HasOne.html
        //$subrow=$row->linked->updateOrCreate($request->all()); //da verificarne il comportamento sembra che voglia anche il token

        //echo '<pre>';print_r($request->all());echo '</pre>';
        //dd($row->linked);

        if ($request->has('post_content_serialized')) {
            $data = \json_decode($request->post_content_serialized);
            PostContent::where('post_id', $params['id_post'])->delete();
            foreach ($data as $el) {
                $el->post_id = $params['id_post'];
                $request->request->add(\get_object_vars($el));

                app(PostContentController::class)->store($request);
            }
        }
        \Session::flash('status', 'Aggiornato ! '.$row->id.' ');

        return redirect()->back();
    }

    /*
    public function seoEdit(Request $request){
        return $this->edit($request);
    }

    public function seoUpdate(Request $request){
        return $this->updateTrait($request);
    }
>>>>>>> messo flash banner su inserimento record

    public function store(Request $request)
    {
        $params = \Route::current()->parameters();

        if (strlen($request->guid)<3) {
            $request->guid=str_slug($request->title);
            $request->request->set('guid', str_slug($request->title));
        }
        $request->_out='model';
        $row = $this->storeTrait($request);
        $row->post_id=$row->id;
        $row->save();
        /* -- post content --
        $id_post=$row->post_id;
        $data = json_decode($request->post_content_serialized);
        foreach ($data as $el) {
            $el->post_id = $id_post;
            $request->request->add(get_object_vars($el));
            app(PostContentController::class)->store($request);
        }

        \Session::flash('status', 'Aggiunto ! '.$row->type.' '. $row->id);
        return redirect()->back();
    }
    */
    /*
    public function update(Request $request)
    {
        $params = \Route::current()->parameters();


        if (strlen($request->guid)<3) {
            $request->guid=str_slug($request->title);
            $request->request->set('guid', str_slug($request->title));
        }

        $this->updateTrait($request);

        if ($request->has('post_content_serialized')) {
            $data = json_decode($request->post_content_serialized);
            PostContent::where('post_id', $params['id_post'])->delete();
            foreach ($data as $el) {
                $el->post_id = $params['id_post'];
                $request->request->add(get_object_vars($el));

                app(PostContentController::class)->store($request);
            }
        }
        return redirect()->back();
    }
    */
    /*
    public function seoEdit(Request $request){
        return $this->edit($request);
    }

    public function seoUpdate(Request $request){
        return $this->updateTrait($request);
    }

    public function seoIndex(Request $request){
        $params = \Route::current()->parameters();
        \Session::flash('status', 'Seo Aggiornato! ');
        return redirect()->route('blog.post.seo.edit',$params);
    }
    */

    public function updateContentTools(Request $request)
    {
        //return $request->_token;
        $regions = '{}';
        $params = $request->all();
        \extract($params);
        $params['regions'] = \json_decode($regions);
        $regions = $params['regions'];
        //echo '<pre>';print_r($params);echo '</pre>';

        foreach ($regions as $k => $v) {
            //echo '-'.$k;
            list($tbl, $field, $id) = \explode('|', $k);
            $row = Post::find($id);
            if ('title' == $field) {
                $v = \strip_tags($v);
                $v = \trim($v);
            }
            $row->$field = $v;
            $row->save();
        }//end foreach
        //return 'ok';
        //return {"readyState":4,"status":200,"statusText":"success"}
        //return response()->json(['readyState' => 4, 'status' => 200,'statusText'=>'success'] );
        return response()->json('', 200);
        //return '';
    }

    //end function
}
