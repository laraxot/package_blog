<?php

namespace XRA\Blog\Controllers\Blog;

use App\Http\Controllers\Controller;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use XRA\Blog\Models\Category;
use XRA\Blog\Models\Post;
use XRA\Blog\Models\Settings;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

class CategoryController extends Controller
{
    public function show(Request $request)
    {
        //$this->authorize('view', $post);
        //return view('blog::posts.show', ['post' => $post]);
        $params = \Route::current()->parameters();
        $row=Post::where('guid', $params['guid_category'])->f();
        $view=CrudTrait::getView();
        return view($view)->with('row', $row);
    }
}
