<?php
namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

//use Laravel\Scout\Searchable;

//use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class PostShopItemVarPivot extends Pivot
{
    //use Updater;
    protected $table = 'blog_post_shop_item_vars';
    protected $fillable = ['post_id', 'post_cat_id'];
    protected $appends = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'post_shop_item_id';
    public $incrementing = true;
    //------------ RELATIONSHIP ---------------
    public function related()
    {
        return $this->hasOne(PostRelated::class, 'post_id', 'post_cat_id')->where('related_id', $this->post_id);
    }

    //------------- MUTUATORS -----------
    public function getPriceAttribute($value)
    {
        return $this->related->price;
    }
}
