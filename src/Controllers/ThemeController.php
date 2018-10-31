<?php

namespace XRA\Blog\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

class ThemeController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new \XRA\Blog\Models\Post;
    }
    /*
    public function show(Request $request,$id){

        return view('pub_theme::pages.'.$id);
    }
    */
}//end class
