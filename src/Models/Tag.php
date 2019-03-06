<?php
namespace Xot\Blog\Models;

use Illuminate\Database\Eloquent\Model;
//--- TRAITS ---
use XRA\Blog\Models\Traits\LinkedTrait;

class Tag extends Model
{
	use LinkedTrait;
    protected $table = 'mp_tags';
}
