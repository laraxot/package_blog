<?php

namespace XRA\Blog\Controllers\Api;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//-------models----------
use XRA\Blog\Models\Post;
//use XRA\Blog\Models\PostRev;
//------services---------
use XRA\Extend\Services\ThemeService as Theme;
use XRA\Blog\Controllers\Api\APIBaseController as APIBaseController;

class Container2Controller extends APIBaseController{
    //use CrudTrait;
    public function index(Request $request){
        //die('['.__LINE__.']['.__FILE__.']');
    	$params = \Route::current()->parameters();
    	extract($params);
    	$model=config('xra.model.'.$container);
        $model_obj=new $model;
        /*
        $lang=\App::getLocale();
        $rows=POST::where('lang',$lang)->where('type',$container)->where('guid','!=',$container);
        
        */
        $rows=$model_obj->where('latitude','>',40);
        $rows=$rows->get();
        return $rows;
    }

    public function show(Request $request){
        //die('['.__LINE__.']['.__FILE__.']');
        return $this->sendResponse('1','ok');
    }

    public function update(Request $request){
        $params = \Route::current()->parameters();
        $result=$request->all();
        $message=$params;
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        if(\Request::ajax()){
            \Debugbar::disable();
        }
        return response()->json($response,200);
    }

}