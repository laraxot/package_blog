<?php
namespace XRA\Blog\Models;

use Carbon\Carbon;
//use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;
use XRA\Extend\Traits\Updater;
//--- services
//--- models ---

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class Photo extends Model
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use Updater;
    protected $table = 'blog_post_photos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'article_type', 'published_at'];
    //protected $appends=['category_id'];
    //protected $casts = [ 'category_id' => 'integer', ];
    protected $dates = ['published_at'/* 'created_at', 'updated_at'*/];
    protected $primaryKey = 'post_id';
    public $incrementing = false;
}