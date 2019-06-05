<?php
use XRA\Extend\Services\RouteService;

$namespace = $this->getNamespace();
$pack = class_basename($namespace);

$namespace .= '\Controllers\Admin';
$middleware = ['web', 'auth'];

$item2=include(__DIR__.'/common.php');
/*
$areas_prgs = [
    $item2,
];
*/
$areas_prgs = [
    //$item1,
    [
        'name' => 'Blog',
        'param_name' => 'lang',
        'only' => ['index'],
        'subs' => [
            $item2,
        ],
    ],
    //$item0,
];

//ddd($areas_prgs);

if ('admin' == \Request::segment(1)) {
    $prefix = 'admin';
    Route::group(
        [
        'prefix' => $prefix,
        'middleware' => $middleware,
        'namespace' => $namespace,
        ],
        function () use ($areas_prgs,$namespace) {
            RouteService::dynamic_route($areas_prgs, null, $namespace);
        }
    );
}
