<?php

namespace XRA\Blog\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

//----- repository ----
//http://lyften.com/projects/laravel-repository/doc/usage.html
use XRA\Blog\Repositories\PostRepository;


trait ContainerTrait{
	/**
     * @var UserRepository
     */
    protected $repository;
    
	public function getModel(){
		//return new Post;
		$params = \Route::current()->parameters();
		extract($params);
		$type=is_object($container0)?$container0->type:$container0;
		$model=config('xra.model.'.$type);
		if($model==''){
			$row=Post::where('lang',\App::getLocale())->where('guid',$type)->first();
			$model=config('xra.model.'.$row->type);
			if($model==''){
				die('<hr/>settare modello['.$row->type.'] in config/xra<hr/>'.'['.__LINE__.']['.__FILE__.']');
			}
		}
		return $model;
	}
	
	public function __construct(PostRepository $repository){
        $this->repository = $repository;

    }

	public function getController(){
		$params = \Route::current()->parameters();
		extract($params);
		$model=$this->getModel();
		if(\Request::is('admin/*')){
			$controller=str_replace('\\Models\\','\\Controllers\\Admin\\',$model);
		}else{
			$controller=str_replace('\\Models\\','\\Controllers\\',$model);
		}
		for($i=1;$i<4;$i++){
			$cont_name='container'.$i;
			if(isset($$cont_name)){
				$cont=$$cont_name;
				$type=is_object($cont)?$cont->type:$cont;
				$controller.='\\'.studly_case($type);	
			}
		}
		$controller.='Controller';
		return $controller;
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

}