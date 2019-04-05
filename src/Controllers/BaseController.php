<?php
namespace XRA\Blog\Controllers;

use App\Http\Controllers\Controller;
//--------- traits -----------
use XRA\Extend\Traits\CrudContainerItemTrait as CrudTrait;

abstract class  BaseController extends Controller
{
    use CrudTrait;
}
