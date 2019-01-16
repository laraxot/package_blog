<?php



namespace XRA\Blog\Models\Traits;

//use Laravel\Scout\Searchable;

//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;

//------ traits ---

trait LinkedTrait
{
    //------- relationships ------------
    public function post()
    {
        //return $this->morphOne(Post::class,'linkable',null,'post_id');
    }

    public function related()
    {
        //belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey,$parentKey, $relatedKey, $relation)
        $pivot_fields = ['type', 'pos', 'price', 'price_currency', 'id'];
        $rows = $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id', 'post_id', 'post_id')
                ->withPivot($pivot_fields)
                ->using(PostRelatedPivot::class)
                ->where('lang', \App::getLocale())
                ->orderBy('blog_post_related.pos', 'asc');
        //->with(['related'])

        return $rows;
    }

    public function relatedType($type)
    {
        if (false === \mb_strpos($type, '_x_')) {
            $type = $this->type.'_x_'.$type;
        }

        return $this->related()->wherePivot('type', $type);
    }

    //------- mutators -------------

    public function getTypeAttribute($value)
    {
        return camel_case(class_basename($this));
    }

    public function getTitleAttribute($value)
    {
        if (isset($this->post)) {
            $value = $this->post->title;
        }

        return $value;
    }

    public function getSubtitleAttribute($value)
    {
        if (isset($this->post)) {
            $value = $this->post->subtitle;
        }

        return $value;
    }

    public function getTxtAttribute($value)
    {
        if (isset($this->post)) {
            $value = $this->post->txt;
        }

        return $value;
    }

    public function getUrlAttribute($value)
    {
        if (isset($this->post)) {
            $value = $this->post->url;
        }

        return $value;
    }
}
