<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//--- TRAITS ---
//use XRA\Blog\Models\Traits\LinkedTrait;

/**
 * XRA\Blog\Models\PostContent.
 *
 * @property \XRA\Blog\Models\Post $Post
 * @mixin \Eloquent
 */
class PostContent extends BaseModel
{
	//use LinkedTrait;
    protected $table = 'blog_post_contents';
    public $incrementing = true;

    public function Post()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
}
