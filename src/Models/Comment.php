<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use XRA\Extend\Traits\Updater;

//--- Models ---//
//use Laralum\Users\Models\User;
use XRA\LU\Models\User;

/**
 * XRA\Blog\Models\Comment
 *
 * @property-read \XRA\Blog\Models\Post $post
 * @property-read \XRA\LU\Models\User $user
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use Searchable;
    use Updater;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'post_id', 'comment'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
