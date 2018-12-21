<?php
namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
 
//--- extends ---
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class ArticleController extends Controller
{
    use CrudTrait;
}
