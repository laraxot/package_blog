<?php
namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;
//--- TRAITS ---
use XRA\Blog\Models\Traits\LinkedTrait;
use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class PostShopItemVar extends Model
{
    use Updater;
    protected $table = 'blog_post_shop_item_vars';
    protected $fillable = ['post_id', 'post_cat_id'];
    protected $appends = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'post_shop_item_id';
    public $incrementing = true;

    //------------- MUTUATORS -----------
    //*
    public function getPriceAttribute($value)
    {
        //$row=PostRelated::where('post_id',$this->post_cat_id)->where('related_id',$this->post_id)->first();
        //return $row->price;
        return 10;
    }
}
