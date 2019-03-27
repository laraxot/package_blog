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
 * XRA\Blog\Models\Category.
 *
 * @property \Illuminate\Database\Eloquent\Collection|\XRA\Blog\Models\Comment[] $comments
 * @property \Illuminate\Database\Eloquent\Collection|\XRA\Blog\Models\Post[]    $posts
 * @mixin \Eloquent
 */
class Category extends BaseModel
{
    //use Searchable;
    //use Updater;
    //use LinkedTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'guid'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }

    public function deletePosts()
    {
        foreach ($this->posts as $post) {
            $post->delete();
        }
    }

    public function deleteComments()
    {
        foreach ($this->comments as $comment) {
            $comment->delete();
        }
    }

    public function url()
    {
        //dd($this->toArray());
        $url = route('blog.category', ['guid_category' => $this->guid]);

        return $url;
    }

    public function formFields()
    {
        //$view=ThemeService::getView(); //non posso usarla perche' restituisce la view del chiamante
        //return view('blog::admin.post.partials.'.strtolower(class_basename($this)) )->with('row',$this);
        return false; //category non ha campi collegati per ora
    }
}
