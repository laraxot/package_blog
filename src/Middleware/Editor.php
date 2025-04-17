<?php



namespace XRA\Blog\Middleware;

use Closure; // <---- importiamo la classe
use Symfony\Component\HttpKernel\Exception\HttpException;

class Editor
{
    /**
     * Handle an incoming request. */
    public function handle($request, Closure $next)
    {
        ddd('aa');
        throw new HttpException(503); // <----- Exception 503
    }

    //end handle
}//end class
