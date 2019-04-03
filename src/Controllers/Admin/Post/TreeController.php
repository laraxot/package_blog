<?php



namespace XRA\Blog\Controllers\Admin\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//--- extends ---
use XRA\Blog\Models\Post;
//--- Models ---//
use XRA\Blog\Models\PostParent;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class TreeController extends Controller
{
    use CrudTrait{
        store as protected storeTrait;
        update as protected updateTrait;
    }

    public function getModel()
    {
        return new Post();
    }

    public function store(Request $request)
    {
        //dd($request->parent_id);
        $params = $request->all();
        \extract($params);
        $request->_out = 'model';
        $request->request->add(['guid' => str_slug($request->title)]);
        $row = $this->storeTrait($request);
        //--- quando genero una nuova riga vado a settare anche il post_id, forse da fare solo per la lingua "portante"
        $row->post_id = $row->id;
        $row->update();
        /*
        $pivot= new PostParent;
        $pivot->post_id=$row->post_id;
        $pivot->parent_id=$request->parent_id;
        $pivot->post_type='parent';
        $pivot->save();
        */
        try {
            $row->related()->attach($parent_id, ['type' => 'parent']);
        } catch (QueryException $e) {
            ddd($e);
        }
        $msg = 'Risorsa salvata! '.$row->id;
        //return $this->saveandexit(['status'=>'success','msg'=>$msg]);
        return $this->saveandcontinue(['row' => $row, 'status' => 'success', 'msg' => $msg]);
        /*
        $routename = \Route::current()->getName();
        \Session::flash('status', $msg);
        $routename = str_replace('.store', '.index', $routename);
        return redirect()->route($routename, $params);
        */
    }

    //end store

    public function update(Request $request)
    {
        $params = $request->all();
        \extract($params);
        $request->_out = 'model';
        $row = $this->updateTrait($request);
        $old_parent_id = $row->parent_id;
        if ($old_parent_id != $parent_id) {
            //die('padri diversi');
            echo '<br/>Tolgo :'.$old_parent_id;
            $row->related()->detach($old_parent_id, ['type' => 'parent']);
            echo '<br/>Aggiungo :'.$parent_id;
            $row->related()->attach($parent_id, ['type' => 'parent']);
        }
        $msg = 'Risorsa salvata! '.$row->id;
        //return $this->saveandexit(['status'=>'success','msg'=>$msg]);
        return $this->saveandcontinue(['row' => $row, 'status' => 'success', 'msg' => $msg]);
        //die('<br/>['.__LINE__.']['.__FILE__.']');
    }

    //end update
}
