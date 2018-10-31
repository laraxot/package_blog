<?php

namespace XRA\Blog\Controllers\Admin;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Controller;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
use XRA\Extend\Traits\ArtisanTrait;

class PageController extends Controller
{
    //use CrudTrait;
    public function show(Request $request, $id)
    {
        //dd($id);
        $view='adm_theme::pages.'.$id;
        if (\View::exists($view)) {
            return view($view);
        } else {
            return '<h3>La view [' . $view . '] non esiste</h3>';
        }
    }
}//end class
