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


trait PostTrait{
    //--------- relationship --------------
    public function post(){
        $row=$this->hasOne(Post::class,'post_id','post_id')
                ->where('lang',\App::getLocale())
                ->where('type',$this->type)
                ->withDefault()
                ;
        return $row;
    }

    public function postOrCreate(){
        $post=$this->post;
        if($post==null){
            $post=Post::firstOrCreate(['guid'=>$this->guid,'type'=>$this->type,'lang'=>\App::getLocale()],['title'=>$this->title]);
            self::where('post_id',$post->post_id)->delete();
            $this->post_id=$post->post_id;
            $this->save();
            $this->post=$post;
        }
        return $post;
    }


    public function related(){
        //return $this->belongsToMany(PostRev::class, 'blog_post_related', 'post_id', 'related_id')
        //belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey,$parentKey, $relatedKey, $relation)
        //echo '<br/>'.$this->type;
        $pivot_fields=['type','pos','price','price_currency','id'];
        $rows= $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id','post_id','post_id')
                ->withPivot($pivot_fields)
                //->using(PostRelatedPivot::class)
                ->where('lang', \App::getLocale())
                //->with(['linked'])
                ;
        //echo '<pre>'.$rows->toSql().'</pre>';
        return $rows;
    }

    public function relatedrev(){
        //return $this->belongsToMany(PostRev::class, 'blog_post_related', 'related_id', 'post_id')
        $pivot_fields=['type','pos','price','price_currency','id'];
        $rows= $this->belongsToMany(Post::class, 'blog_post_related', 'related_id', 'post_id','post_id','post_id')
                ->withPivot($pivot_fields)
                //->using(PostRelatedPivot::class)
                ->where('lang', \App::getLocale());
        //echo '<pre>'.$rows->toSql().'</pre>';
        return $rows;                
    }

    public function relatedType($type){
        if(strpos($type,'_x_')===false){
            $type=$this->type.'_x_'.$type;
        }
        return $this->related()->wherePivot('type', $type);//->where('lang',\App::getLocale());
        //return $this->related->where('pivot.type', $type);//->where('lang',\App::getLocale());
    }

    //----------- mutators --------------------
    public function getTypeAttribute($value){
        return camel_case(class_basename($this));
    }

    //------ functions -------------------
    /*
    public function image_html($params){
        $type='canvas'; // canvas ,cropped
        $class='';
        $src=$this->image_src;
        extract($params);
        $src1=ThemeService::imageResizeSrc($params);
        return '<img src="'.asset($src1).'" alt="'.$this->image_alt.'" title="'.$this->image_title.'"  width="'.$width.'px" height="'.$height.'px" class="'.$class.'"/>';
    }
    */

}//end PostTrait