<?php
namespace XRA\Blog\Models;

use Carbon\Carbon;

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
class RatingMorph extends BaseModel
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    //use Updater;
    //use LinkedTrait;
    //*
    //protected $table = 'blog_post_events';
    protected $fillable = ['id','post_id','post_type','related_id','related_type','rating'];
    protected $appends = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    
}