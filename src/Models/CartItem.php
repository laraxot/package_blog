<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

use XRA\Extend\Services\ThemeService;
//--- services
//use XRA\Extend\Traits\Updater;
//--- TRAITS ---
//use XRA\Blog\Models\Traits\LinkedTrait;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class CartItem extends BaseModel
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    //use Updater;
    //use LinkedTrait;

    protected $table = 'blog_post_shop_items';
    protected $fillable = ['id', 'post_id', 'post_cat_id', 'post_var_cat_id', 'post_id_adds', 'post_id_subs'];
    protected $appends = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;

    //---- relationship ----------
    public function post($post_id = null)
    {
        $lang = \App::getLocale();
        if (null == $post_id) {
            return $this->belongsTo(Post::class, 'post_id', 'post_id');
        }
        $row = Post::where('lang', $lang)->where('post_id', $post_id)->first();

        return $row;
    }

    //------------- RELATIONSHIP -----------
    public function vars()
    {//variations
        /*
         $rows= $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id','post_id','post_id')
                ->withPivot($pivot_fields)
                //->using(PostRelatedPivot::class)
                ->where('lang', \App::getLocale())
                //->with(['related'])
                ;
        */
        $rows = $this->hasMany(PostShopItemVar::class, 'post_shop_item_id', 'id');

        return $rows;
    }

    public function postVars()
    {
        $crosstable = 'blog_post_shop_item_vars';
        $pivot_fields = ['post_cat_id'];
        $rows = $this->belongsToMany(Post::class, $crosstable, 'post_shop_item_id', 'post_id', 'id', 'post_id')
                    ->withPivot($pivot_fields)
                    ->using(PostShopItemVarPivot::class)
                    ;

        return $rows;
    }

    /*
    public function related(){
        $pivot_fields=['type','pos','price','price_currency','id'];
        $rows= $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id','post_id','post_id')
                ->withPivot($pivot_fields)
                //->where('lang', \App::getLocale())
                ;
        //echo '<pre>'.$rows->toSql().'</pre>';
        return $rows;
    }
    */

    public function related()
    {
        return $this->hasOne(PostRelated::class, 'post_id', 'post_cat_id')->where('related_id', $this->post_id);
    }

    //------------- MUTUATORS -----------
    //*

    public function getPriceAttribute($value)
    {
        return $this->related->price;
    }

    //------------- functions --------
    public function total()
    {
        return $this->all()->sum(function ($row) {
            $price = $row->price + $row->postVars->sum('pivot.price');

            return $price * $row->num;
        });
    }

    /*
    public function filter($params){
        $row = new self;
        return $row;
    }//end filter



    public function relatedType($type){
        return $this->post->related()->wherePivot('type', $type);//->where('lang',\App::getLocale());
    }

    public function formFields(){
        //$view=ThemeService::getView(); //non posso usarla perche' restituisce la view del chiamante
        //return view('blog::admin.post.partials.'.strtolower(class_basename($this)) )->with('row',$this);
        return false;
    }
    */
}//end model
