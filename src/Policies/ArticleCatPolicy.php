<?php

namespace XRA\Blog\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use XRA\LU\Models\User;
use XRA\Blog\Models\Article as Post;

class ArticleCatPolicy
{
    use HandlesAuthorization;
   
    public function before($user, $ability)
    {
        if (isset($user->perm) && $user->perm->perm_type>=5) {  //superadmin
            return true;
        }
    }
    
    /*
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
    */

    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user, Post $post)
    {
        if ($post->created_by==$user->handle) {
            return true;
        }
        return false;
    }

    public function show(User $user, Post $post)
    {
        return false;
    }
}
