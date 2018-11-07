<?php

namespace XRA\Blog\Controllers\Admin;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//-------models---
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelated;

class Container0Controller extends Controller{
	
	use CrudTrait{
        index as protected indexTrait;
    }
	
	public function index(Request $request){
		$lang=\App::getLocale();
		$params = \Route::current()->parameters();
		extract($params);
		// ARCHIVIO o FIGLI ????? DILEMMA DILEMMOSO
		if($request->has('syncSons')){
			$items=Post::where('lang',$lang)->where('type',$container0->type)->where('guid','!=',$container0->type)->get();
			foreach($items as $k=>$item){
				PostRelated::firstOrCreate(['post_id'=>$item->post_id,'related_id'=>$container0->post_id,'type'=>'parent']);
			}
			echo '<h3> location linked '.$container0->sons->count().'</h3>';
		}
		if($request->has('syncGuids')){
			$items=Post::where('lang',$lang)->where('type',$container0->type)->where('guid','!=',$container0->type)->get();
			foreach($items as $k=>$item){
				$item->guid=str_slug($item->title);
				$item->save();
			}
		}
		//echo '['.__LINE__.']['.__FILE__.']';
		/*
		$conn=(new Post)->getConnection();
		$sql="update blog_posts set guid=REGEXP_REPLACE(lower(trim(title)),'[^a-z09]','-') where guid is null";
		$res=$conn->statement($sql);
		*/
		$guidnotset=Post::whereRaw('guid=""')->get();
		foreach($guidnotset as $up){
			$title=$up->title;
			if(isset($up->linked) && isset($up->linked->locality)){
				$title.=' '.$up->linked->locality;
			}
			$up->guid=str_slug($title);
			$up->save();
		}


		//--- creazione contenitori se non esistono
		foreach(config('xra.model') as $k => $v){
			Post::firstOrCreate(['lang'=>$lang,'type'=>$k,'guid'=>$k],['title'=>$k]);
		}

		return $this->indexTrait($request);
	}

	public function editContainer(Request $request){
		return $this->edit($request);
	}

	public function updateContainer(Request $request){
		return $this->update($request);
	}
	public function indexContainer(Request $request){
		return redirect()->back();
	}

	public function indexSeo(Request $request){
		return $this->edit($request);
	}

	public function editSeo(Request $request){
		return $this->edit($request);
	}

	public function updateSeo(Request $request){
		return $this->update($request);
	}


	public function updateContentTools(Request $request){
		$regions='{}';
		$params=$request->all();
		extract($params);
		$params['regions']=json_decode($regions);
		$regions=$params['regions'];
		foreach ($regions as $k=>$v) {
			list($tbl, $field, $id)=explode('|', $k);
			$row=Post::find($id);
			if ($field=='title') {
				$v=strip_tags($v);
				$v=trim($v);
			}
			$row->$field=$v;
			$row->save();
		}//end foreach
		//return 'ok';
		//return {"readyState":4,"status":200,"statusText":"success"}
		//return response()->json(['readyState' => 4, 'status' => 200,'statusText'=>'success'] );
		return response()->json('',200);
	}//end function


}//end class
