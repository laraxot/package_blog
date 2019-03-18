<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
//use GrahamCampbell\Markdown\Facades\Markdown;
//use Illuminate\Support\Facades\Auth;
//------- models ---------
//use XRA\Blog\Models\Category;
//use XRA\Blog\Models\Post;
//use XRA\Blog\Models\Settings;
//--------- traits -----------
//use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
//use XRA\Extend\Traits\FrontTrait;
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class ArticleController extends Controller
{
    //use FrontTrait;
    use CrudTrait;
}
