<?php


use XRA\Extend\Traits\RouteTrait;

$namespace = $this->getNamespace();
$pack = class_basename($namespace);

$related = [
    'name' => 'Related',
    'param_name' => 'related',
    'namespace' => 'container',
    'acts' => [
        [
            'name' => 'attach',
        ],
        [
            'name' => '{related}/deattach',
        ], //end act_n
    ], //end acts
]; //end related_node

$item0 = [   //tenuto uguale al front per velocizzare eventuali modifiche
    'name' => '{container}',
    'param_name' => 'item',
    'controller' => 'ContainerController',
    'acts' => [
        [
            'name' => 'editContainer',
        ], //end act_n
        [
            'name' => 'updateContainer',
            'method' => ['PUT', 'PATCH'],
        ], //end act_n
    ], //end acts
    'subs' => [
        [
            'name' => null,
            'prefix' => '{item}',
            'as' => '',
            'subs' => [
                $related,
                [
                    'name' => '{container1}',
                    'param_name' => 'item1',
                    'controller' => 'ContainerController',
                    'subs' => [
                        [
                            'name' => null,
                            'prefix' => '{item1}',
                            'as' => '',
                            //*
                            'subs' => [
                                [
                                    'name' => 'Related',
                                    'param_name' => 'related',
                                    'namespace' => 'container\container1',
                                    'acts' => [
                                        [
                                            'name' => 'attach',
                                        ],
                                        [
                                            'name' => '{related}/deattach',
                                        ], //end act_n
                                    ], //end acts
                                ],
                                [
                                    'name' => '{container2}',
                                    'param_name' => 'item2',
                                    'controller' => 'ContainerController',
                                ], //end sub_n
                            ], //end subs
                        ], //end sub_n
                    ], //end subs
                    //*/
                ], //end sub_n
            ], //end subs
        ], //end sub_n
    ], //ens_subs
];

/* --- se no non mi funziona il contentTools

$post=[
    'name'=>'post',
    'prefix'=>'post',
    'as'=>'post.',
    'namespace'=>'blog',
    'controller'=>'PostController',
    'acts'=>[
        [
            'name'=>'updateContentTools',
            'method'=>['PUT','PATCH','POST'],//'post',
            'act'=>'updateContentTools',
            'as'=>'updateContentTools',
        ],//end act_n
    ],//end acts
    'subs'=>$post_subs,
];

*/

$areas_prgs = [
    [
        'name' => $pack,
        'only' => ['index'],
        'subs' => [
            [
                'name' => null,
                'prefix' => '{lang}',
                'subs' => [
                    $item0,
                ],
            ], //end sub_n
        ], //end subs
    ],
];
$prefix = 'admin';
$middleware = ['web', 'auth'];

Route::group(
    [
    'prefix' => $prefix,
    'middleware' => $middleware,
    'namespace' => $namespace.'\Controllers\Admin',
    ],
    function () use ($areas_prgs) {
        //Route::get('/', 'ContainerController@home');
        //Route::get('/home', 'ContainerController@home'); //togliere o tenere ?
        RouteTrait::dynamic_route($areas_prgs);
    }
);
