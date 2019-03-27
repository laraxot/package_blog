<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

//use XRA\Blog\Models\Traits\LinkedTrait;
//use XRA\Extend\Traits\Updater;

//------services---------
use XRA\Extend\Services\ThemeService;
//------ models --------
use XRA\Blog\Models\Article;


/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class ArticleCat extends BaseModel
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use Updater;
    use LinkedTrait;
    protected $table = 'blog_post_article_cats';
    protected $fillable = ['post_id'];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = true;
    //------- relationship ---

    public function postArticles()
    {
        /*
        $type=$this->post_type.'_x_articles';
        return $this->related()->wherePivot('type',$type);
        */
        return $this->relatedType('article');
    }

    public function articles()
    {
        /*
        $type=$this->post_type.'_x_articles';
        return $this->related()->wherePivot('type',$type);
        */
        $related=Article::class;
        return $this->morphRelated($related);
    }



    //------- functions
    public function formFields()
    {
        return false;
        $roots = Post::getRoots();
        $view = 'blog::admin.partials.'.snake_case(class_basename($this));

        return view($view)->with('row', $this->post)->with($roots);
    }
}
