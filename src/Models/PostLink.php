<?php



namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

//----- traits -------
use XRA\Blog\Models\Traits\PostTrait;
use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class PostLink extends Model
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use PostTrait;
    use Updater;
    protected $table = 'blog_post_links';
    protected $fillable = ['post_id', 'url', 'title', 'type'];
    protected $appends = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = true;
}
