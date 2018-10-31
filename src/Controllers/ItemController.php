<?php

namespace XRA\Blog\Controllers;

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


use Cache;

class ItemController extends Controller{

    //use CrudTrait;
}