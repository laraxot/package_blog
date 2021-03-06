<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

//--- services
use XRA\Extend\Services\ThemeService;
//--- TRAITS ---
//use XRA\Blog\Models\Traits\LinkedTrait;
//use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class Sitemap extends BaseModel
{
    //use LinkedTrait;
    //use Searchable; //se non si crea prima indice da un sacco di errori
    //use Updater;
    protected $table = 'blog_feeds';
    protected $fillable = ['post_id'];

    public function formFields()
    {
        //$view=ThemeService::getView(); //non posso usarla perche' restituisce la view del chiamante
        //return view('blog::admin.post.partials.'.strtolower(class_basename($this)) )->with('row',$this);
        return false;
    }
}
