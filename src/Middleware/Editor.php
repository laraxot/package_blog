<?php
namespace XRA\Blog\Middleware;

use Symfony\Component\HttpKernel\Exception\HttpException; // <---- importiamo la classe
use Closure;

class Editor
{
    /**
    * Handle an incoming request. */
    public function handle($request, Closure $next)
    {
        ddd('aa');
        throw new HttpException(503); // <----- Exception 503
    }//end handle
}//end class
