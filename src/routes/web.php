<?php
use XRA\Extend\Services\RouteService;
$namespace = $this->getNamespace();
$pack = class_basename($namespace);
$namespace .= '\Controllers';
$middleware = ['web', 'guest']; //guest ti riindirizza se non sei loggato
$middleware = ['web'];

$item2=include(__DIR__.'/common.php');

$areas_prgs = [
    $item2,
];

if ('adm3333in' != \Request::segment(1)) { //dal backend si creano i link per il frontend ..
    $prefix = App::getLocale();
    //$prefix=\Request::segment(1);
    //$prefix= LaravelLocalization::setLocale();  //da valutare
    //$middleware= [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ];
    //$prefix='{lang}';
    
    Route::group(
        [
        'prefix' => $prefix,
        //'where' => ['lang' => '[a-zA-Z]{2}'],
        'middleware' => $middleware,
        'namespace' => $namespace,
        ],
        function () use ($areas_prgs,$namespace) {
            Route::get('/', 'HomeController@index'); // different from below because this is for lang
            Route::get('/home', 'HomeController@index'); //togliere o tenere ?
            RouteService::dynamic_route($areas_prgs, null, $namespace);
        }
    );
}



Route::group(['prefix' => null, 'middleware' => $middleware, 'namespace' => $namespace], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index'); //togliere o tenere ?
    Route::get('/redirect', 'HomeController@redirect');
    Route::get('/test01', 'HomeController@test01');
});

$this->routes();