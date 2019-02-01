<?php
namespace XRA\Blog\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use XRA\Food\Models\Photo as Post;
use XRA\LU\Models\User;

class PhotoPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->perm->perm_type >= 5) {  //superadmin
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
        return true;  //se e' loggato puo' creare ristorante non proprietario ristorante
    }

    public function edit(User $user, Post $post)
    {
        if ($post->created_by == $user->handle) {
            return true;
        }

        return false;
    }
    public function update(User $user, Post $post)
    {
        if ($post->created_by == $user->handle) {
            return true;
        }

        return false;
    }

    public function show(User $user, Post $post)
    {
        return false;
    }

    public function delete(User $user, Post $post){
        return true;
    }
    public function indexEdit(User $user, Post $post){
        return true;
    }
}
