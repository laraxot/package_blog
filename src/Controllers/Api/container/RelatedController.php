<?php
namespace XRA\Blog\Controllers\Api\container;

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

class RelatedController extends Controller{
	public function index(Request $request){
		$lang=\App::getlocale();
		$params = \Route::current()->parameters();
		$row=last($params);
		extract($params);
		$view=CrudTrait::getView();
		return view($view)->with($params)->with('params',$params)->with('view',$view)->with('row',$row);
	}
}