<?php

namespace XRA\Blog\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller{

    public function index(){
        return view('pub_theme::article.search.index')
            ->with('lang',\App::getLocale())
            ;
    }

}
