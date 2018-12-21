<?php
use XRA\Extend\Services\RouteService;

$namespace=$this->getNamespace();
$pack=class_basename($namespace);

$namespace.='\Controllers\Admin';
$middleware=['web','auth'];

$acts=[
    ['name'=>'attach',],//end act_n
    ['name'=>'detach','method'=>['DELETE','GET'],],//end act_n
    ['name'=>'moveUp','method'=>['PUT','GET']],
    ['name'=>'moveDown','method'=>['PUT','GET']],
];//end acts

$item0=[
    'name'=>'{container0}',
    'param_name'=>'item0',
    'subs'=>[
        [
            'name'=>'{container1}',
            'param_name'=>'item1',
            'acts'=>$acts,
            'subs'=>[
                [
                    'name'=>'{container2}',
                    'param_name'=>'item2',
                    'acts'=>$acts,
                    'subs'=>[
                        [
                            'name'=>'{container3}',
                            'acts'=>$acts,
                            'param_name'=>'item3',
                        ],//end sub_n
                    ],//end subs
                ],//end sub_n
            ],//end subs
        ],
    ],//ens_subs
];

$item1=[
    'name'=>'{container0}',
    'param_name'=>'',
    'only'=>[],
    'subs'=>[
        [
            'name'=>'search',
            'param_name'=>'query',
            'only'=>['index','show',],
        ],
        [
            'name'=>'map',
            'param_name'=>'query',
            'only'=>['index','show',],
        ],
    ],

];

$areas_prgs=[
    //$item1,
    [
        'name'=>'Blog',
        'param_name'=>'lang',
        'only'=>['index'],
        'subs'=>[
            $item0,
        ],
    ],
    //$item0,
];


if (\Request::segment(1)=='admin') {
    $prefix='admin';
    Route::group(
        [
        'prefix' => $prefix,
        'middleware' =>$middleware,
        'namespace'=>$namespace
        ],
        function () use ($areas_prgs,$namespace) {
            RouteService::dynamic_route($areas_prgs, null, $namespace);
        }
    );
}
