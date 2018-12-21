<?php

namespace XRA\Blog\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//------traits -----
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

class SearchController extends Controller
{
    use CrudTrait;
}
