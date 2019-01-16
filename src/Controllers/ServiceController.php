<?php



namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class ServiceController extends Controller
{
    use CrudTrait;

    public function getModel()
    {
        return new \XRA\Blog\Models\Post();
    }

    /*
    public function show(Request $request,$id){

        return view('pub_theme::pages.'.$id);
    }
    */
}//end class
