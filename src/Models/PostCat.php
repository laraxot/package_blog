<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

//------ traits ----
use XRA\Blog\Models\Traits\PostTrait;
use XRA\Extend\Traits\ImportTrait;
use XRA\Extend\Traits\Updater;
use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;
//--- services
use XRA\Extend\Services\ThemeService;


use Laravel\Scout\Searchable;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector;
//--------- models --------
use XRA\Blog\Models\Post;

class PostCat extends Model
{
    //
    use Updater;
    use Searchable;
    use ImportTrait;
    use PostTrait;

    protected $table = "blog_post_cats";
    protected $primaryKey = 'post_id';
    public $incrementing = false;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'published_at',
    ];

    protected $fillable = [
        'post_id', //importante per le tabelle collegate
    ];
    //-------- relationship ------
    public function posts()
    {
        $type=$this->type.'_x_post';
        return $this->related()->wherePivot('type', $type);
    }

    //-------- mutators ------
    
    public function formFields()
    {
        //$view=ThemeService::getView(); //non posso usarla perche' restituisce la view del chiamante
        //return view('blog::admin.post.partials.restaurant')->with('row',$this);
        return null;
    }
}
