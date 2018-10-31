<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

/**
 * XRA\Blog\Models\PostContent
 *
 * @property-read \XRA\Blog\Models\Post $Post
 * @mixin \Eloquent
 */
class PostContent extends Model
{
    protected $table = 'blog_post_contents';

    public function Post()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
}
