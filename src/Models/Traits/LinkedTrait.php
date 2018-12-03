<?php
namespace XRA\Blog\Models\Traits;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

use Carbon\Carbon;
//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;


//------ traits ---
use XRA\Extend\Traits\Updater;
use XRA\Extend\Services\ThemeService;


trait LinkedTrait{
    //------- relationships ------------
    public function post(){
        //return $this->morphOne(Post::class,'linkable',null,'post_id');
    }

    public function related(){
		//belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey,$parentKey, $relatedKey, $relation)
		$pivot_fields=['type','pos','price','price_currency','id'];
		$rows= $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id','post_id','post_id')
				->withPivot($pivot_fields)
				->using(PostRelatedPivot::class)
				->where('lang', \App::getLocale())
				->orderBy('blog_post_related.pos','asc');
				//->with(['related'])
				;
		return $rows;
	}

    public function relatedType($type){
        if(strpos($type,'_x_')===false){
			$type=$this->type.'_x_'.$type;
        }
        return $this->related()->wherePivot('type', $type);
    }

    //------- mutators -------------

    public function getTypeAttribute($value){
        return camel_case(class_basename($this));
    }

    public function getTitleAttribute($value){
        if(isset($this->post))
            $value=$this->post->title;
        return $value;
    }

    public function getSubtitleAttribute($value){
        if(isset($this->post))
            $value=$this->post->subtitle;
        return $value;
    }

    public function getTxtAttribute($value){
        if(isset($this->post))
            $value=$this->post->txt;
        return $value;
    }

    public function getUrlAttribute($value){
        if(isset($this->post))
            $value=$this->post->url;
        return $value;
    }



}
