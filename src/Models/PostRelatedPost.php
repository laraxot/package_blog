<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

/**
 * XRA\Blog\Models\PostContent
 *
 * @property-read \XRA\Blog\Models\Post $Post
 * @mixin \Eloquent
 */
class PostRelatedPost extends Model {
	protected $table = 'blog_post_related_post';
    protected $primaryKey = 'id';
}