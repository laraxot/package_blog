<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
//--- extends ---
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class PostCatController extends Controller{
	use CrudTrait;
}