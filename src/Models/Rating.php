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
class Rating extends BaseModel
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    //use Updater;
    //use LinkedTrait;
    //*
    //protected $table = 'blog_post_events';
    protected $fillable = ['post_id','my_rating'];
    protected $appends = ['my_rating'];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = true;
    


    public function morph($model){
        
    }


    public function getMyRatingAttribute($value){
        ddd($value);
    }

    public function setMyRatingAttribute($value){
        $params = \Route::current()->parameters();
        list($container,$item)=\params2ContainerItem($params);
        $n_container=count($container);
        $n_item=count($item);
        $item_last=$item[$n_item-1];
        //ddd($item_last);

        /*
        $pivot=$this->pivot;
        if(is_object($pivot)){
            $pivot->update(['rating'=>$value]);
        }else{
            ddd($this);
        }
        //unset($this->attibutes['my_rating']);
        */
        $auth_user_id=\Auth::user()->auth_user_id;
        //ddd($this);//"post_id" => 1  "related_type" => "restaurant"
        $pivot=RatingMorph::firstOrCreate(
            [
                'post_type'=>$this->related_type,
                'post_id'=>$item_last->post_id,
                'related_id'=>$this->post_id,
                'auth_user_id'=>$auth_user_id,
            ]
        );
        $pivot->rating=$value;
        $pivot->save();

    }

}