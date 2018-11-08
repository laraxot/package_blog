<?php

namespace XRA\Blog\Controllers\Admin\Blog\Container0\Container1;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

//use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

use XRA\Extend\Traits\ArtisanTrait;

//-------models----------
use XRA\Blog\Models\Post;
//use XRA\Blog\Models\PostRev;
//------services---------
use XRA\Extend\Services\ThemeService as Theme;

//----- repository ----
//http://lyften.com/projects/laravel-repository/doc/usage.html
use XRA\Blog\Repositories\PostRepository;
/*
Target [Illuminate\Database\Eloquent\Model] is not instantiable while building [XRA\Blog\Controllers\ContainerController, XRA\Blog\Repositories\PostRepository].
*/


use Cache;

class Container2Controller extends Controller{
	//use CrudTrait;

	 /**
     * @var UserRepository
     */
    protected $repository;

	public function getModel(){
		return new Post;
	}
	//*
	public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }
	//*/
	public function getController(){
		$params = \Route::current()->parameters();
		extract($params);

		//dd($params);die;

		if(is_object($container0)){
			$type=$container0->type;
		}else{
			$type=$container0;
		}
		$model=config('xra.model.'.$type);
		if($model==''){
			$row=Post::where('lang',\App::getLocale())->where('guid',$type)->first();
			$model=config('xra.model.'.$row->type);
			if($model==''){
				die('<hr/>settare modello['.$row->type.'] in config/xra<hr/>'.'['.__LINE__.']['.__FILE__.']');
			}
		}
		$controller=str_replace('\\Models\\','\\Controllers\\',$model);
		if(isset($container1)){
			if(is_object($container1)){
				$controller.='\\'.studly_case($container1->type);
			}else{
				$controller.='\\'.studly_case($container1);
			}
		}
		if(isset($container2)){
			if(is_object($container1)){
				$controller.='\\'.studly_case($container2->type);
			}else{
				$controller.='\\'.studly_case($container2);
			}

		}
		$controller.='Controller';
		return $controller;
	}



	public function alignLang(){
		$rows_it=Post::where('lang','it')->get();
		foreach($rows_it as $row_it){
			//$row_lang=PostRev::where('lang', $lang)->where('guid', $row_it->guid)->first();
			$row_lang=Post::where('lang', $lang)->where('guid', $row_it->guid)->first();
			if($row_lang===null){
				$row_lang=$row_it->replicate();
				$row_lang->lang=$lang;
				$row_lang->id=null;
				$row_lang->save();
			}
		}
	}


	public function __call($method, $args) {
		//ddd($args);
		$controller=$this->getController();
		if(in_array($method,['store','update'])){
			$request=str_replace('\\Controllers\\','\\Requests\\',$controller);
			$request=substr($request,0,-strlen('Controller'));
			$pos=strrpos($request,'\\');
			$request=substr($request,0,$pos+1).studly_case($method).substr($request,$pos+1);
			
			$request=$request::capture();
			$request->validate($request->rules());
			return app($controller)->$method($request);
		}else{
			return app($controller)->$method(Request::capture());
		}
		//return app($controller)->$method($args);
  	}

	public function home_redirect(Request $request){
		return redirect(\App::getLocale());
	}


	public function home(Request $request){
		$lang=\App::getLocale();
		$params = \Route::current()->parameters();
		if ($request->routelist==1) {
			return ArtisanTrait::exe('route:list');
		}
		if ($request->migrate==1) {
			config(['app.APP_ENV' => 'local']);
			return ArtisanTrait::exe('migrate');
		}
		if ($request->clearcache==1 || $request->force==1) {
			\Cache::flush();
		}
		extract($params);
		//$guid='home';
		//$row=Post::firstOrCreate(['lang'=>$lang,'guid'=>$guid,'type'=>$guid],['title'=>'home '.$lang]);
		//Theme::setMetatags($row);
		//ddd(config('xra.model'));
		$roots=[];
		foreach(config('xra.model') as $k=>$v){
			$roots[$k]=Post::firstOrCreate(['lang'=>$lang,'guid'=>$k,'type'=>$k],['title'=>$k.' '.$lang]);
		}

		/*
		$roots=Post::where('lang',$lang)->whereRaw('guid = type ')->get();
		$roots=$roots->keyBy('type')->all();
		$roots['home']=$row;
		*/
		$view = CrudTrait::getView($params);
		//$view='pub_theme::index';
		return view($view)
				->with('view',$view)
				->with('lang',$lang)
				->with('row',$roots['home'])
				->with($params)
				->with($roots);
	}
	/*
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
	*/

}//end class
