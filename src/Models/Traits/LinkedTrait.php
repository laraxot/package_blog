<?php



namespace XRA\Blog\Models\Traits;

//use Laravel\Scout\Searchable;

//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;

//------ traits ---

trait LinkedTrait
{
    //------- relationships ------------
    public function post()
    {
        //update blog_posts set linkable_type=type
        //return $this->morphOne(Post::class,'linkable',null,'post_id')->where('lang',$this->lang);
        return $this->hasOne(Post::class,'post_id','post_id')->where('type',$this->type)->where('lang',$this->lang); 
    }

    public function morphRelated($related){
        //-- name post perche' dopo va a cercare il proprio oggetto dentro $name .'_type';
        // percio' post_type=restaurant 
        $name='post';//'related';//'relatable'; 
        $table ='blog_post_related'; 
        $foreignPivotKey = 'post_id';
        $relatedPivotKey = 'related_id'; 
        $parentKey = 'post_id';
        $relatedKey = 'post_id'; 
        $inverse = false;
        $pivot_fields = ['type', 'pos', 'price', 'price_currency', 'id'];
        return $this->morphToMany($related, $name,$table, $foreignPivotKey,
                                $relatedPivotKey, $parentKey,
                                $relatedKey, $inverse)
                    ->withPivot($pivot_fields)
                    //->using(PostRelatedPivot::class) /// Call to undefined method  setMorphType() ??
                    ->orderBy('blog_post_related.pos', 'asc');
                    ; 
    }


    public function related()
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
        if (isset($this->post)) {
            $value = $this->post->title;
        }

        return $value;
    }

    public function getSubtitleAttribute($value)
    {
        if (isset($this->post)) {
            $value = $this->post->subtitle;
        }

        return $value;
    }

    public function getTxtAttribute($value)
    {
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
            return $second_last->linkedOrCreate->tabs;
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


}
