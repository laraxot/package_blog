<?php


use XRA\Extend\Traits\RouteTrait;

$namespace = $this->getNamespace();

$namespace .= '\Controllers';

$middleware = ['web', 'guest']; //guest ti riindirizza se non sei loggato
$middleware = ['web'];

$prefix = 'blog';
Route::get('/home', function () {
    return redirect(\App::getLocale());
});

Route::get('redirect', function () {
    $data = \Request::all();

    return redirect($data['url']);
});

/*
$item0=[
    'name'=>'',
    'prefix'=>'{container}',
    'as'=>'container.',
    'param_name'=>'item',
    'namespace'=>null,
    'controller' =>  'ContainerController',
    //'only'=>['index','show','create'],
    'subs'=>[
        [
            'name'=>'search',
            'prefix'=>'search',
            'as'=>'search',
            'param_name'=>'query',
            'namespace'=>'container',
            'controller'=>'SearchController',
            'only'=>['index','show',],
        ],//end sub_n
    ],//end subs
];
//*/
/*
$item0=[
    'name'=>'{container}',
    'controller' =>  'ContainerController',
    'subs'=>[
        [
            'name'=>'{cat}',
            'controller' =>  'container\CatController',
            'subs'=>[
                [
                    'name'=>'{item}',
                    'controller' =>  'container\cat\ItemController',
                ]
            ],//end subs

        ],
    ],//end subs

];
//*/
/*
$item0=[
    'name'=>'{container}',
    'param_name'=>'item',
    'controller' =>  'ContainerController',
    'subs'=>[
        [
            'name'=>'search',
            'param_name'=>'query',
            'controller' =>  'SearchController',
            'only'=>['index','show',],
        ],
        [
            'name'=>'{item}',
            'param_name'=>'container1',
            'controller' =>  'Container1Controller',
            //'prefix'=>'{item}',
            'subs'=>[
                [
                    'name'=>'{container1}',
                    'param_name'=>'item1',
                    'controller' =>  'Item1Controller',
                ],//end sub_n
            ],//end subs
        ],
    ],//end subs
];
tu
//*/
$item0 = [
    'name' => '{container}',
    'param_name' => 'item',
    'controller' => 'ContainerController',
    'acts' => [
        ['name' => 'steps'],
        ['name' => 'check_steps'],
    ],
    'subs' => [
        [
            'name' => 'search',
            'param_name' => 'query',
            'controller' => 'SearchController',
            'only' => ['index', 'show'],
        ],
        [
            'name' => null,
            'prefix' => '{item}',
            'as' => '',
            //'controller' =>  'ContainerController',

            'subs' => [
                [
                    'name' => '{container1}',
                    'param_name' => 'item1',
                    'controller' => 'ContainerController',
                    'acts' => [
                        [
                            'name' => 'attach',
                        ], //end act_n
                    ], //end acts
                    //*
                    'subs' => [
                        [
                            'name' => null,
                            'prefix' => '{item1}',
                            'as' => '',
                            //*
                            'subs' => [
                                [
                                    'name' => '{container2}',
                                    'param_name' => 'item2',
                                    'controller' => 'ContainerController',
                                ], //end sub_n
                            ], //end subs
                            //*/
                        ], //end sub_n
                    ], //end subs
                    //*/
                ], //end sub_n
            ], //end subs
        ], //end sub_n
    ], //ens_subs
];

$areas_prgs = [
    $item0,
];
//,'middleware' => ['web','auth']
$prefix = App::getLocale();
//$prefix='{locale}';
Route::group(['prefix' => $prefix, 'middleware' => $middleware, 'namespace' => $namespace], function () use ($areas_prgs) {
    Route::get('/', 'ContainerController@home');
    Route::get('/home', 'ContainerController@home'); //togliere o tenere ?
    RouteTrait::dynamic_route($areas_prgs);
});

//*-- API --
Route::group(
    [
    'prefix' => 'api/'.App::getLocale(),
    'middleware' => ['api', 'web'],
    'namespace' => $namespace.'\Api', 'as' => 'api.', ],
    function () use ($areas_prgs) {
        RouteTrait::dynamic_route($areas_prgs);
    }
);
//*/

Route::group(['prefix' => null, 'middleware' => $middleware, 'namespace' => $namespace], function () {
    Route::get('/', 'ContainerController@home');
});

$this->routes();
