<?php
namespace XRA\Blog\Controllers\Admin\ArticleCat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//--- extends ---
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class ArticleController extends Controller
{
    use CrudTrait;
}
