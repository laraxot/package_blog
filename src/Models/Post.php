<?php
namespace XRA\Blog\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
//--- traits ---
use XRA\Extend\Traits\Updater;
//---- services --
use XRA\Extend\Services\ImageService;
use XRA\Extend\Services\ImportService;
use XRA\Extend\Services\ThemeService;


//--- models ---
use XRA\LU\Models\User;

class Post extends Model //NO BaseModel
{
	//use FilterTrait;
	//use Searchable; //ne update quando aggiungo un array mi da errore
	use Updater;
	//use ImportTrait;
	//use PostTrait;

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'published_at',
	];

	protected $casts = [
		//'is_admin' => 'boolean',
		//'content' => 'array',
		//'content_type' => 'array',
		'image_resize_src' => 'array',
		//'url' => 'array',
		'url_lang' => 'array',
		//'linked_count' => 'array',
		//'related_count' => 'array',
		//'relatedrev_count' => 'array',
		//'tags' => 'string',
		//'parent_id' => 'integer',
	];

	//protected $primaryKey = ['post_id','lang'];  //problemi ovunque nel crud
	//protected $primaryKey = 'post_id';  //aggiorna sempre tutti anche quelli delle lingue diverse, fino a bug risolto usiamo PostRev

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $connection = 'mysql'; // this will use the specified database conneciton
	protected $table = 'blog_posts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'post_id', //importante per le tabelle collegate
		'lang',
		'title',
		'subtitle',
		'guid',
		//'type',
		'post_type', //da type a post_type per il morph
		'txt',
		'image_src', 'image_alt', 'image_title',
		'meta_description',
		'meta_keyword',
		'author_id',
		'created_at',
		'updated_at',
		'published',
		//'tags',
		'title',
		'description',
		'content',
		'parent_id',  //nella prox versione forse va a prendere il setAttributeId
		'url',
		'url_lang', //buffer
		'image_resize_src', // buffer
		'linked_count', // buffer
		'related_count', // buffer
		'relatedrev_count', //buffer
	];

	protected $appends = [/*'linked',*//*'category_id',*//*'tags',*//*'parent_id'*//*,'pivot'*/]; // category_id dipende dalla tabella linked

	protected $primaryKey = 'id';  //no give error because the key is post_id + lang
	public $incrementing = true;


	public function getRouteKeyName()
	{
		return 'guid';
		//return \Request::segment(1) === 'admin' ? 'post_id' : 'guid';
	}

	//-------- relationship ------
	public function linkable(){
		return $this->morphTo('post');
	}
	public function archive(){
		$lang=$this->lang;
		$post_type=$this->post_type;
		$obj=$this->getLinkedModel();
		$table=$obj->getTable();
		//*
		$rows=$obj->join('blog_posts','blog_posts.post_id',$table.'.post_id')
                    ->where('lang',$lang)
                    ->where('blog_posts.post_type',$post_type)
                    ->where('blog_posts.guid','!=',$post_type)
                    ->orderBy($table.'.updated_at','desc')
                    //->paginate(200)
                    ->with('post')
                    //->get()
                    ;
        //*/
		/*                    
        $rows=$this->hasMany($obj,'post_type','post_type')->join('blog_posts','blog_posts.post_id',$table.'.post_id')
                    ->where('lang',$lang)
                    ->where('blog_posts.post_type',$post_type)
                    ->orderBy($table.'.updated_at','desc')
                    //->paginate(200)
                    ->with('post')
                    //->get()
                    ;
        */
        return $rows;
	}//end function

	public function archiveRand($n){
		$obj=$this->getLinkedModel();
		///* 19568
		$cache_key=$this->post_type.'-'.$this->post_id.'-'.$n;
	   // $obj=$this;
		$rows = Cache::get($cache_key,  function () use($obj,$n){
			return $obj->inRandomOrder()->limit($n)->get();
			//return $this->archive()->inRandomOrder()->limit($n)->get();
		});
		return $rows;
		//*/
	}

	public function relatedPivot($obj)
	{
		$parz = [];
		$parz['post_id'] = 		$this->post_id;
		$parz['related_id'] = 	$obj->post_id;
		//$parz['type'] = $this->post_type.'_x_'.$obj->post_type;
		$parz['post_type'] = 	$this->post_type;
		$parz['related_type'] = $obj->post_type;
		$pivot = PostRelated::firstOrCreate($parz);

		return $pivot;
	}


	//-------- mutators ---------
	public function getParentTabsAttribute($value){
        $params = \Route::current()->parameters();
        //$second_last = collect(\array_slice($params, -2))->first(); //penultimo
        $n_params=count($params);
        $second_last=collect($params)->take(-2)->first();
        if(is_object($second_last) && $n_params>1){
            return $second_last->tabs;
        }
    }

    public function getGuidAttribute($value){
    	if($value!='') return $value;
    	$value=Str::slug($this->attributes['title'].' ');
    	$this->guid=$value;
    	$this->save();
    	return $value;
    }

    public function getRoutenameAttribute($value){
    	$value=$this->getRoutename();
    	return $value;
    }

    public function getUrlAttribute($value){
		if (isset($this->pivot)) {
			return $this->pivot->url;//.'#PIVOT';
		}
		$value=$this->getUrl();
		if ('' == $value) {
			$this->setUrlAttribute($value);
			$value = $this->attributes['url'];
		}
		return url($value);//.'#NO-PIVOT';
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
    //-------- scopes ------------
    public function scopeOfSearch($query, $term){
        /*
        $columns = \implode(', ', \array_keys($this->toSearchableArray())); // da scout
        if($columns==''){ // se vuoto cerco ovunque
        	$columns=$this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        	$columns=\implode(', ',$columns);
        }
        */
        $columns='title, subtitle, txt';
        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , \fullTextWildcards($term));
        /*
		$ris=$conn->statement('ALTER TABLE '.$table.' ADD FULLTEXT fulltext_index ('.$columns.')');
        */
        return $query;
    }
	//-------- functions ---------
	public function getRouteN($n, $act,$params=null){
		if($params==null){
			$params = \Route::current()->parameters();
		}
		$params['container'.$n] = $this->post_type;
		$params['item'.$n] = $this->guid;
		$route=$this->getRoutenameN($n, $act);
		/*
		//$params['lang'] = $this->lang;
		//$params['container'.($n + 1)] = $this->related->post_type;
		//$params['item'.($n + 1)] = $this->related->guid;
		$r = '';
		for ($i = 0; $i <= ($n ); ++$i) {
			$r .= 'container'.$i.'.';
		}
		$route = $r.$act;
		*/
		if (in_admin()) {
			//$route = 'blog.'.$route;
		}
		try{
			$url= route($route, $params,false);  //con il false mi da il relativo
		}catch(\Exception $e){
			$url='#fix['.$route.']['.__LINE__.']['.__FILE__.']';
		}
		$url_arr=explode('/',$url);
		if(isset($url_arr[1]) && strlen($url_arr[1])==2){
			$url_arr[1]=$this->lang;
		}
		$url=implode('/',$url_arr);
		return $url;
		//return $route;
	}

	public function getRoutenameN($n, $act){
		$r = '';
		for ($i = 0; $i <= ($n ); ++$i) {
			$r .= 'container'.$i.'.';
		}
		$routename = $r.$act;
		return $routename;
	}

	public function getRoutename(){
		$params = \Route::current()->parameters();
		list($containers,$items)=$this->params2ContainerItem($params);

		$i=null; // quando trovo la collection giusta la sostituisco
		foreach($containers as $k=>$container){
			if($container->post_type == $this->post_type){
				$i=$k; break;
			}
		}

		//ddd('item');
		$j=null; // quando trovo la collection giusta la sostituisco
		foreach($items as $k=>$item){
			if(is_object($item) && $item->post_type == $this->post_type && $item->guid == $this->guid){
				$j=$k; break;
			}
		}

		$roots=config('xra.roots');
		if(!is_array($roots)){
			$roots=[];
		}

		if(strtolower($this->post_type)!=strtolower($this->guid) && in_array($this->post_type,$roots)){
			return $this->getRoutenameN(0, 'show');//.'#2['.$i.']['.$j.']';
		}


		if(strtolower($this->post_type)==strtolower($this->guid)){
			return $this->getRoutenameN($i, 'index');//.'#1['.$i.']['.$j.']';
		}
		if($i===null){
			return $this->getRoutenameN(0, 'show');//.'#2['.$i.']['.$j.']';
		}
        if($j===null){
        	return $this->getRoutenameN($i, 'show');//.'#3['.$i.']['.$j.']';
        }
        return $this->getRoutenameN($j, 'show');//.'#4['.$i.']['.$j.']';

	}

	public function getUrl(){
		$params = \Route::current()->parameters();
		list($containers,$items)=$this->params2ContainerItem($params);

		$i=null; // quando trovo la collection giusta la sostituisco
		foreach($containers as $k=>$container){
			if($container->post_type == $this->post_type){
				$i=$k; break;
			}
		}

		//ddd('item');
		$j=null; // quando trovo la collection giusta la sostituisco
		foreach($items as $k=>$item){
			if(is_object($item) && $item->post_type == $this->post_type && $item->guid == $this->guid){
				$j=$k; break;
			}
		}

		$roots=config('xra.roots');
		if(!is_array($roots)){
			$roots=[];
		}

		if(strtolower($this->post_type)!=strtolower($this->guid) && in_array($this->post_type,$roots)){
			return $this->getRouteN(0, 'show');//.'#2['.$i.']['.$j.']';
		}


		if(strtolower($this->post_type)==strtolower($this->guid)){
			return $this->getRouteN($i, 'index');//.'#1['.$i.']['.$j.']';
		}
		if($i===null){
			return $this->getRouteN(0, 'show');//.'#2['.$i.']['.$j.']';
		}
        if($j===null){
        	return $this->getRouteN($i, 'show');//.'#3['.$i.']['.$j.']';
        }
        return $this->getRouteN($j, 'show');//.'#4['.$i.']['.$j.']';
		/*
        return $this->getRouteN(0, 'show').'#5['.$i.']['.$j.']';
        if($j==null){
        	return $this->getRouteN($i, 'index').'#3['.$i.']['.$j.']';
        }
        return $this->getRouteN($j, 'show').'#4['.$i.']['.$j.']';
        		//ddd('-['.$i.']['.$j.']'.$this->post_type.' '.$this->guid);
		//ddd($i);
		*/
	}
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
        $str2='_url';
        $name=substr($name, 0,-strlen($str2));
        return $this->getUrlAct($name);//.'#NO-PIVOT';
    }

    public function getUrlAct($act){
		$params = \Route::current()->parameters();
		list($containers,$items)=\params2ContainerItem($params);
		$routename = \Request::route()->getName();
		$ris = null;
		$routename_arr = \explode('.', $routename);
		foreach ($params as $k => $v) {
			if (\is_object($v) && ($v->is($this) || $v->is($this->linkable)) ) {
				$ris = $k;
				break;
			}
		}

		$ris_tmp = \str_replace('item', 'container', $ris);
		$k = \array_search($ris_tmp, $routename_arr, true);
		//ddd($routename_arr);
		/*
		if($k<1){
			echo '[['.$k.']]';
			ddd($ris);
		}
		*/
		//ddd($k);

		

		if ($ris_tmp == $ris && 'edit' == $act && $ris!=null) {
			$n = \str_replace('container', '', $ris);
			$params['item'.$n] = $params['container'.$n];
		}
		if ($ris_tmp != $ris && 'index' == $act) {
			$act = 'show';
		}


		if($ris_tmp == $ris  && $ris=='' && $k==false){
			$routename_act = \implode('.', \array_slice($routename_arr, 0, -1)).'.'.$act;
			//ddd($routename_act);
			//$routename_act = \implode('.', \array_slice($routename_arr, 0, $k + 1)).'.'.$act;
			//ddd($routename_act); //blog.container0.update
			//$routename_act='admin.'.$routename_act;
		}else{
			$routename_act = \implode('.', \array_slice($routename_arr, 0, $k + 1)).'.'.$act;
		}
		if (starts_with($routename_act, '.')) { // caso da homepage
			$routename_act = 'container0'.$routename_act;
			$params['container0'] = $this->guid;
		}
		
		/*
		if(\Route::exists($routename_act)){
			return route($routename_act, $params);
		}else{
			return '#'.$routename_act;
		}
		*/
		try{
			return route($routename_act, $params);
		}catch(\Exception $e){
			//ddd($params);
			//ddd($routename_arr);
			//ddd($routename.' '.$routename_act.' '.$act.' '.($k+1) );
			//ddd(($ris_tmp == $ris). $k);
			return '#[POST][424]'.$routename_act;
		}
	}

	public function params2ContainerItem($params){
		$container=[];
		$item=[];
		foreach($params as $k=>$v){
			$pattern='/(container|item)([0-9]+)/';
			preg_match($pattern, $k,$matches);
			if(isset($matches[1]) && isset($matches[2]) ){
				$sk=$matches[1];
				$sv=$matches[2];
				$$sk[$sv]=$v;
			};
		}
		return [$container,$item];
	}


	public function getLinkedModel(){
		$model=config('xra.model.'.$this->post_type);
		if (class_exists($model)) {
			return new $model;
		}else{
			ddd('class not exists ['.$model.']');
		}
	}


	public static function getRoots()
	{
		$lang = \App::getLocale();
		$all = config('xra.model');
		if($all==null){
			$all=[];
			//ddd('miss config xra.model');
		}
		$seconds=60*60*24;
		$cache_key=$_SERVER['SERVER_NAME'].'_roots';
		try{
		    $roots = Cache::remember($cache_key, $seconds,function () use($lang,$all){
			//mettendo with archive mi da errore
			//con related = 48 senza =  47
			return self::with([])->where('lang', $lang)
					->whereIn('guid',array_keys($all)) //la query durava 1.2 sec ora 1/10
					->whereRaw('guid = post_type ')
					->get();
		    });
		}catch(\Exception $e){
		   //Cache::pull($cache_key); //vado a rigenerarlo
		   $roots=self::with([])->where('lang', $lang)
					->whereIn('guid',array_keys($all)) //la query durava 1.2 sec ora 1/10
					->whereRaw('guid = post_type ')
					->get();
		}
		$roots = $roots->keyBy('post_type')->all();
		$add = collect(\array_keys($all))->diff(\array_keys($roots));
		foreach ($add as $k => $v) {
			$roots[$v] = self::firstOrCreate(['lang' => $lang, 'guid' => $v, 'post_type' => $v], ['title' => $v.' '.$lang]);
		}
		if($add->count()>0){
			Cache::pull($cache_key); //vado a rigenerarlo
		}
		//ddd($roots['home']);
		/// ??? togliere quelli che non ci sono ?
		return $roots;
	}


	public function imageResizeSrc($params)
	{
		$type = 'canvas'; //default value;
		\extract($params);
		$src = $this->image_src;
		$dim = $width.'x'.$height.'_'.$type;
		$buff = $this->image_resize_src;
		if (!\is_array($buff)) {
			$buff = [];
		}
		if (isset($buff[$dim])) {
			if ('/' != $buff[$dim][0]) {
				$buff[$dim] = '/'.$buff[$dim];
			}

			return asset($buff[$dim]);
		}
		$image_path = $src;
		$str = asset('');
		if (\mb_substr($this->image_src, 0, \mb_strlen($str)) == $str) {
			$image_path = public_path(\str_replace($str, '', $this->image_src));
		}
		$image_path=str_replace(
			DIRECTORY_SEPARATOR.'public_html'.DIRECTORY_SEPARATOR.'laravel-filemanager'.DIRECTORY_SEPARATOR,
			DIRECTORY_SEPARATOR.'public_html'.DIRECTORY_SEPARATOR,
			$image_path
		);
		$params['image_path'] = $image_path;
		$src1 = ImageService::image_resized_canvas($params);
		$buff[$dim] = $src1;
		if (isset($this->relatedrev_count)) {
			unset($this->relatedrev_count);
		}
		if (isset($this->restaurantsrev_count)) {
			unset($this->restaurantsrev_count);
		}
		if (isset($this->alls_count)) {
			unset($this->alls_count);
		}
		$this->image_resize_src = $buff;
		$this->save();

		return asset($buff[$dim]);
	}

	public function image_html($params){
		$type = 'canvas'; // canvas ,cropped
		$class = '';
		$src = $this->image_src;
		\extract($params);
		$src1 = $this->imageResizeSrc($params);

		return '<img src="'.asset($src1).'" alt="'.$this->image_alt.'" title="'.$this->image_title.'"  width="'.$width.'px" height="'.$height.'px" class="'.$class.'"/>';
	}


	public function urlLang($lang)
	{

		$url = $this->url_lang;
		//$url=[]; //forzo rigenerazione x debug

		if (!isset($url[$lang])) {
			$url[$lang]=$this->generateUrlLang($lang);
			$this->url_lang = $url;
			$this->save();
		}
		$routename = \Route::current()->getName();
		$route_arr=explode('.',$routename);
		$act=last($route_arr);
		//ddd($act);
		if($act!='index' && $act!='show'){
			return url($url[$lang].'/'.$act);
		}
		return url($url[$lang]);

	}

	public function generateRowLang($lang){
		if($lang==$this->lang) return $this;
		$post=Post::where('post_id',$this->post_id)->where('post_type',$this->post_type)->where('lang',$lang)->first();
		if($post!=null) return $post;
		$rowlang = $this->replicate();
		
		$rowlang->lang = $lang;
		$fields = ['title', 'subtitle', 'txt', 'image_alt', 'image_title'];//campi da tradurre
		foreach ($fields as $field) {
			$tmp = ImportService::trans(['q' => $this->$field, 'from' => $this->lang, 'to' => $lang]);
			if ('' != $tmp) {
				$rowlang->$field = $tmp;
			}
		}
		$rowlang->url = null; //forzo rigenerazione
		if(in_array('type',array_keys($rowlang->attributes))) {
			unset($rowlang->attributes['type']);
		}
		if(in_array('linkable_type',array_keys($rowlang->attributes) )) {
			unset($rowlang->attributes['linkable_type']);
		}
		
		$rowlang->save();
		return $rowlang;
	}


	public function generateUrlLang($lang){
		//--- se il post ha "problemi"
		if (!$this->post_id) {
			$segments = \Request::segments();
			$segments[0] = $lang;
			$url = (\implode('/', $segments));
			return $url;
		}
		//--- prendo la riga di traduzione
		$row = self::where('post_id', $this->post_id)->where('lang', $lang)->first();

		if (null == $row) { //se non esiste la genero
			$row=$this->generateRowLang($lang);
		}
		$url= str_replace(url('/'),'',$row->url);
		//ddd($url);
		//ddd($row->attributes['url']);
		return $url;
	}
	//------------------------------------
    public function item($guid){
    	$rows=$model->where('lang',$this->lang)
                    ->where('guid',$guid)
                    ->where('post_type',$this->post_type)
                    ;
        return $rows->first();
    }


}//end class
