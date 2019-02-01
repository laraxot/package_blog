<?php



namespace XRA\Blog\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use XRA\Blog\Models\Category;
use XRA\Users\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if ('delete' != $ability && User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can access categories.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('XRA::blog.categories.access');
    }

    /**
     * Determine if the current user can create categories.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('XRA::blog.categories.create');
    }

    /**
     * Determine if the current user can view categories.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function view($user)
    {
        return User::findOrFail($user->id)->hasPermission('XRA::blog.categories.view');
    }

    /**
     * Determine if the current user can update categories.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function update($user, Category $category)
    {
        return User::findOrFail($user->id)->hasPermission('XRA::blog.categories.update');
    }

    /**
     * Determine if the current user can delete categories.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function delete($user, Category $category)
    {
        if (Category::first()->id == $category->id) {
            return false;
        }

        $user = User::findOrFail($user->id);

        return $user->superAdmin() || $user->hasPermission('XRA::blog.categories.delete');
    }

    public function indexEdit(User $user, Post $post){
        return true;
    }
}
