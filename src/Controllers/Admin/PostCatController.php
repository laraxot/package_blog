<?php
namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
 
//--- extends ---
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

//--- Models ---//
use XRA\Blog\Models\PostContent;
use XRA\Blog\Models\PostRelated;
use XRA\Blog\Models\Post;
//use XRA\Blog\Models\PostRev;

class PostCatController  extends Controller{
	use CrudTrait;
}