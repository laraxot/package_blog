<?php
namespace XRA\Blog\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use XRA\Blog\Models\Event as Post;
use XRA\LU\Models\User;

class RatingPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if (is_object($user->perm) && $user->perm->perm_type >= 5) {  //superadmin
            return true;
        }
       
    }

    public function create(User $user, Post $post)
    {
        return true;  //se e' loggato puo' creare ristorante non proprietario ristorante
    }


}