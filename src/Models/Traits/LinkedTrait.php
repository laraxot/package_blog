<?php
namespace XRA\Blog\Models\Traits;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

use Carbon\Carbon;
use XRA\Extend\Traits\Updater;
//----- models------
use XRA\Blog\Models\Post;

//------ traits ---
use XRA\Extend\Services\ThemeService;


trait LinkedTrait{
    //------- relationships ------------
    public function post(){
        return $this->morphOne(Post::class,'linkable',null,'post_id');
    }
    //------- mutators -------------
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