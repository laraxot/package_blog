<?php
namespace XRA\Blog\Models\Traits;

//use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;
use XRA\Blog\Models\PostRelatedMorphPivot;

//------ traits ---

trait LinkedTrait
{

    public function getRouteKeyName()
    {
        return 'guid';
        //return \Request::segment(1) === 'admin' ? 'post_id' : 'guid';
    }
    //------- relationships ------------
    public function post()
    {
        //update blog_posts set linkable_type=type
        return $this->morphOne(Post::class,'post',null,'post_id')->where('lang',$this->lang);
        //return $this->hasOne(Post::class,'post_id','post_id')->where('type',$this->type)->where('lang',$this->lang); 
    }

    public function morphRelated($related,$inverse=false){
        //-- name post perche' dopo va a cercare il proprio oggetto dentro $name .'_type';
        // percio' post_type=restaurant
        $related_table=with(new $related)->getTable();
        $alias=array_flip(config('xra.model'));
        if(!isset($alias[$related])){
            ddd($related);
        }
        $related_type=($alias[$related]); 
        $name='post';//'related';//'relatable'; 
        $table ='blog_post_related'; 
        $foreignPivotKey = 'post_id'; 
        $relatedPivotKey = 'related_id'; 
        $parentKey = 'post_id';
        $relatedKey = 'post_id'; 
        //$inverse = false; //passato da parametro
        $pivot_fields = ['type', 'pos', 'price', 'price_currency', 'id','post_type','related_type'];
        return $this->morphToMany($related, $name,$table, $foreignPivotKey,
                                $relatedPivotKey, $parentKey,
                                $relatedKey, $inverse)
                    ->withPivot($pivot_fields)
                    ->wherePivot('related_type', $related_type)
                    ->using(PostRelatedMorphPivot::class)
                    //------------------------------ 
                    ->join('blog_posts','blog_posts.post_id','=',$related_table.'.post_id')
                    ->where('blog_posts.post_type',$related_type)
                    ->where('blog_posts.lang',$this->lang)
                    //--------------------------------
                    ->orderBy('blog_post_related.pos', 'asc')
                    ->with(['post'])
                    ; 
    }
public function morphRelatedRev($related/*,$inverse=false*/){
        //-- name post perche' dopo va a cercare il proprio oggetto dentro $name .'_type';
        // percio' post_type=restaurant
        $related_table=with(new $related)->getTable(); 
        $name='post';//'related';//'relatable'; 
        $table ='blog_post_related'; 
        $foreignPivotKey = 'related_id';         //where `blog_post_related`.`post_id_1` = 220792
        $relatedPivotKey = 'post_id';      //chiave `blog_post_related`.`related_id_2`
        $parentKey = 'post_id';                 //chiave che gli passo
        $relatedKey = 'post_id';              //chiave di blog_post_restaurants`.`post_id_4`
        $inverse = true; //passato da parametro
        $pivot_fields = ['type', 'pos', 'price', 'price_currency', 'id','post_type','related_type'];
        return $this->morphToMany($related, $name,$table, $foreignPivotKey,
                                $relatedPivotKey, $parentKey,
                                $relatedKey, $inverse)
                    ->withPivot($pivot_fields)
                    ->using(PostRelatedMorphPivot::class) /// Call to undefined method  setMorphType() ??
                    ->orderBy('blog_post_related.pos', 'asc')
                    ->with(['post'])
                    ->join('blog_posts','blog_posts.post_id','=',$related_table.'.post_id')
                    ->where('blog_posts.lang',$this->lang)
                    ; 
    }


    public function related_solo_per_toglirtr()
    {
        //belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey,$parentKey, $relatedKey, $relation)
        $pivot_fields = ['type', 'pos', 'price', 'price_currency', 'id'];
        $rows = $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id', 'post_id', 'post_id')
                ->withPivot($pivot_fields)
                ->using(PostRelatedPivot::class)
                ->where('lang', \App::getLocale())
                ->orderBy('blog_post_related.pos', 'asc');
        //->with(['related'])

        return $rows;
    }

    public function relatedType($type)
    {
        if (false === \mb_strpos($type, '_x_')) {
            $type = $this->type.'_x_'.$type;
        }

        return $this->related()->wherePivot('type', $type);
    }

    //------- mutators -------------

    public function getTypeAttribute($value)
    {
        return camel_case(class_basename($this));
    }

    public function getLangAttribute($value){
        $lang=\App::getLocale();
        return $lang;
    }

    public function getTitleAttribute($value)
    {
        if($value!=null) return($value);
        if (isset($this->post)) {
            $value = $this->post->title;
        }

        return $value;
    }
    public function getGuidAttribute($value)
    {
        if($value!=null) return($value); 
        if (isset($this->post)) {
            $value = $this->post->guid;
        }

        return $value;
    }

    public function getSubtitleAttribute($value)
    {
        if($value!=null) return($value);
        if (isset($this->post)) {
            $value = $this->post->subtitle;
        }

        return $value;
    }

    public function getTxtAttribute($value)
    {
        if($value!=null) return($value);
        if (isset($this->post)) {
            $value = $this->post->txt;
        }

        return $value;
    }

    public function getUrlAttribute($value)
    {
        if (isset($this->post)) {
            $value = $this->post->url;
        }
        return $value;
    }

    public function urlActFunc($func,$value){
        $str0='get';
        $str1='Attribute';
        $name=substr($func, strlen($str0),-strlen($str1));
        $name=Str::snake($name);
        if (isset($this->pivot)) {
            return $this->pivot->$name;//.'#PIVOT';
        }
        if (isset($this->post)) {
            return $this->post->$name;
        }
        return $value;
    }

    public function getEditUrlAttribute($value)     {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getMoveupUrlAttribute($value)   {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getMovedownUrlAttribute($value) {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getIndexUrlAttribute($value)    {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getShowUrlAttribute($value)     {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getIndexEditUrlAttribute($value){return $this->urlActFunc(__FUNCTION__,$value);}
    public function getCreateUrlAttribute($value)   {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getUpdateUrlAttribute($value)   {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getDestroyUrlAttribute($value)  {return $this->urlActFunc(__FUNCTION__,$value);}
    public function getDetachUrlAttribute($value)   {return $this->urlActFunc(__FUNCTION__,$value);}


    public function getTabsAttribute($value){
        //if($this->post->guid!=$this->post->type){
            //ddd($this->post->guid.'  '.$this->post->type);
            //ddd('['.$this->attributes['guid'].']  ['.$this->attributes['type'].']');
        //    return ['cuisine','photo','article','contact','map'];
        //}
    }

    public function getParentTabsAttribute($value){
        $params = \Route::current()->parameters();
        //$second_last = collect(\array_slice($params, -2))->first(); //penultimo
        $n_params=count($params);
        $second_last=collect($params)->take(-2)->first();        
        if(is_object($second_last) && $n_params>1){
            return $second_last->tabs;
        }
    }

    //----------------------------------------------
    public function imageResizeSrc($params){
        $value=null;
        if (isset($this->post)) {
            $value = $this->post->imageResizeSrc($params);
        }

        return $value;
    }

    public function image_html($params){
        $value=null;
        if (isset($this->post)) {
            $value = $this->post->image_html($params);
        }

        return $value;    
    }

    public function urlLang($params){
        if (!isset($this->post)) {
            return '#';
        }
        return $this->post->urlLang($params);
    }

    public function linkedFormFields(){
        $roots = Post::getRoots();
        $view = 'blog::admin.partials.'.snake_case(class_basename($this));
        return view($view)->with('row', $this->post)->with($roots);
    }


}
