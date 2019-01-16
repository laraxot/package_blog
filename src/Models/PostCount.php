<?php



namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class PostCount extends Model
{
    //use Searchable; //se non si crea prima indice da un sacco di errori

    protected $table = 'blog_post_count';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'relationship', 'type', 'q'];

    /*
    protected $appends=['category_id'];
    protected $casts = [
        'category_id' => 'integer',
    ];
    protected $dates=['published_at', 'created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = false;


    public function filter($params){
        $row = new self;
        return $row;
    }//end filter
    */
    //--------- relationship ---------------
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }
}
