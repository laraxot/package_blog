<?php



namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * XRA\Blog\Models\PostContent.
 *
 * @property \XRA\Blog\Models\Post $Post
 * @mixin \Eloquent
 */
class PostRelatedPost extends Model
{
    protected $table = 'blog_post_related_post';
    protected $primaryKey = 'id';
}
