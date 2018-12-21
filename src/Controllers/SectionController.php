<?php

namespace XRA\Blog\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\FrontTrait as FrontTrait;
//use XRA\Extend\Traits\ArtisanTrait;

use XRA\Blog\Models\Category;
use XRA\Blog\Models\Post;
use XRA\Blog\Models\Settings;

class SectionController extends Controller
{
    use FrontTrait;
}//end class
