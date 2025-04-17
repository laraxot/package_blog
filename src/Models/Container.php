<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;
//--- TRAITS ---
//use XRA\Blog\Models\Traits\LinkedTrait;
//use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class Container extends BaseModel
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    //use Updater;
    //use Searchable;
    //use LinkedTrait;
    protected $table = 'blog_posts';
}
