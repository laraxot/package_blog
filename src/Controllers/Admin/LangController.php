<?php
namespace XRA\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

//---- services ----
use XRA\Extend\Services\ThemeService;


class LangController extends Controller
{
    //use CrudTrait;
    public function show(Request $request, $id)
    {
        //dd($id);
        $view = 'adm_theme::pages.'.$id;
        if (\View::exists($view)) {
            return view($view);
        } else {
            return '<h3>La view ['.$view.'] non esiste</h3>['.__LINE__.']['.__FILE__.']';
        }
    }
}//end class
