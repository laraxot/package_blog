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

class Page extends Model{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use Updater;
    protected $table = "blog_post_pages";
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id','article_type','published_at','category_id'];
    protected $appends=['category_id'];
    protected $casts = [
        'category_id' => 'integer',
    ];
    protected $dates=['published_at',/* 'created_at', 'updated_at'*/];
    protected $primaryKey = 'post_id';
    public $incrementing = false; 

    public function filter($params){
        $row = new self;
        return $row;
    }//end filter
    
    //--------- relationship ---------------
    public function post(){
        return $this->belongsTo(Post::class,'post_id','post_id');
    }


    public function relatedType($type){
        $post=$this->post;
        if($post==null){
            //dd($this->post_id); //null
            return null;
        }
        return $post->related()->wherePivot('type', $type);//->where('lang',\App::getLocale());
    }
    //---------- mututars -----------
    /*
    public function getPublishedAtAttribute($value){
        return Carbon::parse($value)->formatLocalized('%d/%m/%Y %I:%M %p');
        //return $value->formatLocalized('%d/%m/%Y %H:%M');
    }
    //*/
    public function setPublishedAtAttribute($value){
        //-- with datetimelocal
        if(is_string($value)){
            $value=Carbon::parse($value);
        }
        $this->attributes['published_at'] = $value; //->toDateString();
    }
    /*
    public function getArticleTypeAttribute($value){
        dd(\Request::input('category_id'));
    }
    */


    public function setArticleTypeAttribute($value){
        //dd();
        $this->setCategoryIdAttribute(\Request::input('category_id'));
        $this->attributes['article_type']=$value;
    }
    
    //*
    public function getCategoryIdAttribute($value){
        if($this->relatedType('category')==null) return null;
        $row=$this->relatedType('category')->first();
        if($row==null) return null;
        return $row->post_id;
    }
    //*/


    public function setCategoryIdAttribute($value){
        //die('</hr>['.__LINE__.']['.__FILE__.']');
        $post=$this->post;
        if($post==null){
            dd('['.__LINE__.']['.__FILE.']');
        }
        $post->related()->wherePivot('type','article_x_category')->detach();
        $post->related()->attach($value, ['type'=>'article_x_category']);
    }

   
    //--------- functions -----------
    

    public function formFields(){
        //$view=CrudTrait::getView(); //non posso usarla perche' restituisce la view del chiamante
        return view('blog::admin.post.partials.'.strtolower(class_basename($this)) )->with('row',$this);
    }

    /**
     * Convert a DateTime to a storable string.
     *
     * @param  \DateTime|int  $value
     * @return string
     */
    //public function fromDateTime($value){
    	//dd($value);//19/09/2017 12:06 AM
    	//print_r($value);
    	//$ris=Carbon::createFromFormat('d/m/Y H:i a',$value);
    	//dd($ris);
    	//return $ris;
	//}
}//end model
