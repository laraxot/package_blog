<?php



namespace XRA\Blog\Models;

use Carbon\Carbon;
//use Laravel\Scout\Searchable;

use Illuminate\Database\Eloquent\Model;
//------services---------
use XRA\Extend\Services\ThemeService;
use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class Home extends Model
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    use Updater;
    protected $table = 'blog_post_pages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'article_type', 'published_at', 'category_id'];
    protected $appends = ['category_id'];
    protected $casts = [
        'category_id' => 'integer',
    ];
    protected $dates = ['published_at'/* 'created_at', 'updated_at'*/];
    protected $primaryKey = 'post_id';
    public $incrementing = false;

    public function filter($params)
    {
        $row = new self();

        return $row;
    }

    //end filter

    //--------- relationship ---------------
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function relatedType($type)
    {
        $post = $this->post;
        if (null == $post) {
            //dd($this->post_id); //null
            return null;
        }

        return $post->related()->wherePivot('type', $type); //->where('lang',\App::getLocale());
    }

    //---------- mututars -----------
    /*
    public function getPublishedAtAttribute($value){
        return Carbon::parse($value)->formatLocalized('%d/%m/%Y %I:%M %p');
        //return $value->formatLocalized('%d/%m/%Y %H:%M');
    }
    //*/
    public function setPublishedAtAttribute($value)
    {
        //-- with datetimelocal
        if (\is_string($value)) {
            $value = Carbon::parse($value);
        }
        $this->attributes['published_at'] = $value; //->toDateString();
    }

    /*
    public function getArticleTypeAttribute($value){
        dd(\Request::input('category_id'));
    }
    */

    public function setArticleTypeAttribute($value)
    {
        //dd();
        $this->setCategoryIdAttribute(\Request::input('category_id'));
        $this->attributes['article_type'] = $value;
    }

    //*
    public function getCategoryIdAttribute($value)
    {
        if (null == $this->relatedType('category')) {
            return null;
        }
        $row = $this->relatedType('category')->first();
        if (null == $row) {
            return null;
        }

        return $row->post_id;
    }

    //*/

    public function setCategoryIdAttribute($value)
    {
        //die('</hr>['.__LINE__.']['.__FILE__.']');
        $post = $this->post;
        if (null == $post) {
            dd('['.__LINE__.']['.__FILE.']');
        }
        $post->related()->wherePivot('type', 'article_x_category')->detach();
        $post->related()->attach($value, ['type' => 'article_x_category']);
    }

    //--------- functions -----------

    public function formFields()
    {
        $roots = Post::getRoots();
        $view = 'blog::admin.partials.'.snake_case(class_basename($this));
        if (\View::exists($view)) {
            return view($view)->with('row', $this->post)->with($roots);
        } else {
            echo '<h3>'.\Route::currentRouteAction().'</h3>';
            //ddd(ThemeService::view_path($view));
            $msg = '';
            $msg .= \chr(13).\chr(10).'<h3>la view ['.$view.'] non esiste <br/>';
            $msg .= \chr(13).\chr(10).'pub_theme= '.config('xra.pub_theme').'</h3>';
            $msg .= \chr(13).\chr(10).'adm_theme= '.config('xra.adm_theme').'</h3>';
            $msg .= \chr(13).\chr(10).'['.__LINE__.']['.__FILE__.']';
            /* -- for debug --
            $hints=\View::getFinder()->getHints();
            $pub_theme_index=$hints['pub_theme'][0].DIRECTORY_SEPARATOR.'index.blade.php';
            ddd($pub_theme_index.':'.file_exists($pub_theme_index));
            */
            die($msg);
        }
    }

    /*
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
