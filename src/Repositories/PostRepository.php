<?php



namespace XRA\Blog\Repositories;

//use XRA\XRA\Repositories\BaseRepository;
use XRA\Blog\Models\Post;
use XRA\XRA\Repositories\AbstractRepository;

class PostRepository extends AbstractRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    protected $model = Post::class;
}
