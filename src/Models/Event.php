<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

use Carbon\Carbon;
use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post
 *
 * @mixin \Eloquent
 */

class Event extends Model
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use Updater;
    protected $table = "blog_post_events";
    protected $fillable = ['post_id'];
    protected $appends=[];
    protected $dates=['created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = false;

    public function filter($params)
    {
        $row = new self;
        return $row;
    }//end filter

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function relatedType($type)
    {
        return $this->post->related()->wherePivot('type', $type);//->where('lang',\App::getLocale());
    }

    public function formFields()
    {
        return false;
    }
}//end model
