<?php
namespace XRA\Blog\Models\Traits;

//use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;
use XRA\Blog\Models\PostRelatedMorphPivot;
//----- services -----
use XRA\Extend\Services\ThemeService;
//------ traits ---

trait LinkedTrait
{

    public function getRouteKeyName()
    {
        //return 'guid';
        //return \Request::segment(1) === 'admin' ? 'post_id' : 'guid';
        return \inAdmin() ? 'post_id' : 'guid';
    }
    //------- relationships ------------
    public function post()
    {
        //update blog_posts set linkable_type=type
        return $this->morphOne(Post::class,'post',null,'post_id')->where('lang',$this->lang);
        //return $this->hasOne(Post::class,'post_id','post_id')->where('type',$this->post_type)->where('lang',$this->lang); 
    }

    public function morphRelated($related,$inverse=false){
        //-- name post perche' dopo va a cercare il proprio oggetto dentro $name .'_type';
        // percio' post_type=restaurant
        $related_table=with(new $related)->getTable();
        $related_class=$related;
        if(is_object($related_class)){
            $related_class=get_class($related_class);
            //ddd($related_class);
        }
        $related_type=collect(config('xra.model'))->search($related_class);
        //ddd(is_object($related));
        if($related_type==''){
            //var_dump(debug_backtrace());
            echo '<h3>Line:['.__LINE__.']<br/>File:['.__FILE__.']['.$related_class.'] da mettere in xra.model</h3>';
            echo '<pre>';print_r(var_dump(config('xra.model')));echo '</pre>';
            //var_dump(debug_backtrace());
            ddd('fix');

        }
        //ddd($related);
        //if(!isset($alias[$related])){
        //    ddd($related);
        //}
        //$related_type=($alias[$related]); 
        $name='post';//'related';//'relatable'; 
        $pivot_table ='blog_post_related';
        /*
        $pivot_class=$related_class.'Pivot';
        $pivot_obj=new $pivot_class;
        */
        //ddd($pivot_obj->getFillable()); //peril withpivot
        //ddd($pivot_obj->getTable()); //per passare al morph il nome tabella
        
        //ddd($related_class.'Pivot');// con questo avrei i fillable, e il getTable
        //$pivot_table=$related_table.'_pivot';  
        $foreignPivotKey = 'post_id'; 
        $relatedPivotKey = 'related_id'; 
        $parentKey = 'post_id';
        $relatedKey = 'post_id'; 
        //$inverse = false; //passato da parametro
        $pivot_fields = [ 'pos', 'price', 'price_currency', 'id','post_type','related_type']; //'type', tolto
        return $this->morphToMany($related, $name,$pivot_table, $foreignPivotKey,
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
                    ->orderBy($pivot_table.'.pos', 'asc')
                    ->with(['post'])
                    ; 
    }
public function morphRelatedRev($related/*,$inverse=false*/){
        //-- name post perche' dopo va a cercare il proprio oggetto dentro $name .'_type';
        // percio' post_type=restaurant
        $related_table=with(new $related)->getTable();
        $related_class=$related;
        if(is_object($related_class)){
            $related_class=get_class($related_class);
            //ddd($related_class);
        }
        $related_type=collect(config('xra.model'))->search($related_class);

        $name='post';//'related';//'relatable'; 
        $table ='blog_post_related'; 
        $foreignPivotKey = 'related_id';         //where `blog_post_related`.`post_id_1` = 220792
        $relatedPivotKey = 'post_id';      //chiave `blog_post_related`.`related_id_2`
        $parentKey = 'post_id';                 //chiave che gli passo
        $relatedKey = 'post_id';              //chiave di blog_post_restaurants`.`post_id_4`
        $inverse = true; //passato da parametro
        $pivot_fields = ['pos', 'price', 'price_currency', 'id','post_type','related_type'];
        return $this->morphToMany($related, $name,$table, $foreignPivotKey,
                                $relatedPivotKey, $parentKey,
                                $relatedKey, $inverse)
                    ->withPivot($pivot_fields)
                    ->using(PostRelatedMorphPivot::class) /// Call to undefined method  setMorphType() ??
                    //----------------------------------------------------------------------
                    ->join('blog_posts','blog_posts.post_id','=',$related_table.'.post_id')
                    ->where('blog_posts.post_type',$related_type) // da testare, verificare 
                    ->where('blog_posts.lang',$this->lang)
                    //----------------------------------------------------------------------
                    ->orderBy('blog_post_related.pos', 'asc')
                    ->with(['post'])
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
            $type = $this->post_type.'_x_'.$type;
        }

        return $this->related()->wherePivot('type', $type);
    }

    //------- mutators -------------

    public function getTypeAttribute($value)
    {
        return camel_case(class_basename($this));
    }

    public function getPostTypeAttribute($value)
    {
        //if($value!='') return $value; ??????????????????????????????????????????
        //return 'aa';
        //ddd(snake_case(class_basename($this)));
        //no camel_case ma snake_case
        //da controllare prima questo
        $post_type=collect(config('xra.model'))->search(get_class($this).'aa');
        if($post_type===false){
            $post_type=snake_case(class_basename($this));
        }
        return $post_type;
    }

    public function getLangAttribute($value){
        $lang=\App::getLocale();
        return $lang;
    }

    public function setGuidAttribute($value){
        if($value==''){
            $this->post->guid=Str::slug($this->attributes['title'].' '.$this->attributes['subtitle']);
            $res=$this->post->save();
        }
    }


    public function postAttribute($func,$value){
        $str0='get';
        $str1='Attribute';
        $name=substr($func, strlen($str0),-strlen($str1));
        $name=Str::snake($name);
        if(class_basename($this)=='Post'){
            //ddd($name);//create_url
        }
        if (isset($this->pivot)) {
            //return $this->pivot->$name;//.'#PIVOT';
        } 
        if (isset($this->post)) {
            return $this->post->$name;
        }
        return $value;
    }
    //---- da mettere i mancanti --- 
    public function getTitleAttribute($value)       {return $this->postAttribute(__FUNCTION__,$value);}
    public function getSubtitleAttribute($value)    {return $this->postAttribute(__FUNCTION__,$value);}
    public function getGuidAttribute($value)        {return $this->postAttribute(__FUNCTION__,$value);}
    public function getImageSrcAttribute($value)    {return $this->postAttribute(__FUNCTION__,$value);}
    public function getTxtAttribute($value)         {return $this->postAttribute(__FUNCTION__,$value);}
    public function getUrlAttribute($value)         {return $this->postAttribute(__FUNCTION__,$value);}
    public function getRoutenameAttribute($value)   {return $this->postAttribute(__FUNCTION__,$value);}
    

    public function urlActFunc($func,$value){
        $str0='get';
        $str1='Attribute';
        $name=substr($func, strlen($str0),-strlen($str1));
        $name=Str::snake($name);
        if(class_basename($this)=='Post'){
            //ddd($name);//create_url
        }
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
        //if($this->post->guid!=$this->post->post_type){
            //ddd($this->post->guid.'  '.$this->post->post_type);
            //ddd('-['.$this->attributes['guid'].']  ['.$this->attributes['type'].']');
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

    //------------------------------------
    public function item($guid){
        if(in_admin()){
            $rows=$this->join('blog_posts','blog_posts.post_id','=',$this->getTable().'.post_id')
                                ->where('lang',$this->lang)
                                ->where('blog_posts.post_id',$guid)
                                ->where('blog_posts.post_type',$this->post_type)
                                ;    
        }else{
            $rows=$this->join('blog_posts','blog_posts.post_id','=',$this->getTable().'.post_id')
                                ->where('lang',$this->lang)
                                ->where('blog_posts.guid',$guid)
                                ->where('blog_posts.post_type',$this->post_type)
                                ;
        }
        /* -- testare i tempi
        $rows=$this->whereHas('post',function($query) use($guid){
            $query->where('guid',$guid);
        });
        */                                
        return $rows->first();
    }
    //---------------------------------
    public function listItemSchemaOrg($params){

       
        $tmp=explode('\\',get_class($this));
        $ns=Str::snake($tmp[1]);
        $pack=Str::snake($tmp[3]);
        $view=$ns.'::schema_org.list_item.'.$pack;
        if(!\View::exists($view)){
            ddd('not exists ['.$view.']');
        }
        $row=$this;
        foreach($params as $k=>$v){
            $row->$k=$v;
        }
        return view($view)->with('row',$row);
    }

}
