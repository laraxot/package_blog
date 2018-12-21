<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

use Carbon\Carbon;
use XRA\Extend\Traits\Updater;
use XRA\Blog\Models\Traits\LinkedTrait;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post
 *
 * @mixin \Eloquent
 */

class ArticleCat extends Model
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use Updater;
    use LinkedTrait;
    protected $table = "blog_post_article_cats";
    protected $fillable = ['post_id',];
    protected $dates=['created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = true;
    //------- relationship ---

    public function articles()
    {
        /*
        $type=$this->type.'_x_articles';
        return $this->related()->wherePivot('type',$type);
        */
        return $this->relatedType('article');
    }

    //------- functions
    public function formFields()
    {
        return false;
        $roots=Post::getRoots();
        $view='blog::admin.partials.'.snake_case(class_basename($this));
        return view($view)->with('row', $this->post)->with($roots);
    }
}
