<?php
namespace XRA\Blog\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
	public function archive(){  
		$lang=$this->lang;
		$type=$this->post_type;
		$obj=$this->getLinkedModel();
		$table=$obj->getTable();

		$rows=$obj->join('blog_posts','blog_posts.post_id',$table.'.post_id')
                    ->where('lang',$lang)
                    ->where('post_type',$type)
                    ->orderBy($table.'.updated_at','desc')
                    //->paginate(200)
                    ->with('post')
                    //->get()
                    ;
        return $rows;
	}//end function
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
	//-------- functions --------- 
	public function getLinkedModel(){
		
		$model=config('xra.model.'.$this->post_type);
		return new $model;
	}


	public static function getRoots()
	{
		$lang = \App::getLocale();
		$all = config('xra.model');

		$roots = Cache::get('roots', function () use($lang,$all){
			//mettendo with archive mi da errore
			//con related = 48 senza =  47
			return self::with([])->where('lang', $lang)
					->whereIn('guid',array_keys($all)) //la query durava 1.2 sec ora 1/10 
					->whereRaw('guid = post_type ')
					->get();
		});
		$roots = $roots->keyBy('post_type')->all();
		$add = collect(\array_keys($all))->diff(\array_keys($roots));
		foreach ($add as $k => $v) {
			$roots[$v] = self::firstOrCreate(['lang' => $lang, 'guid' => $v, 'post_type' => $v], ['title' => $v.' '.$lang]);
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
		$post=Post::where('post_id',$this->post_id)->where('type',$this->post_type)->where('lang',$lang)->first();
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


}//end class