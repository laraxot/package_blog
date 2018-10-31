<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use XRA\Extend\Traits\Updater;

/**
 * XRA\Blog\Models\Settings
 *
 * @mixin \Eloquent
 */
class Settings extends Model
{
    use Searchable;
    use Updater;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text_editor', 'public_url'];
}
