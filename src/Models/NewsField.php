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
class NewsField extends BaseModel
{
    //use LinkedTrait;
    protected $table = 'blog_news_fields';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'published_at',
        'date_news',
        'date_start',
        'date_end',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function Post()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
}
