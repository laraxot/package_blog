<?php


use XRA\Extend\Services\RouteService;
use XRA\Extend\Traits\RouteTrait;

$namespace = $this->getNamespace();

$namespace .= '\Controllers';

$middleware = ['web', 'guest']; //guest ti riindirizza se non sei loggato
$middleware = ['web'];

$prefix = 'blog';
/*
Route::get('/home', function () {
    return redirect(\App::getLocale());
});
*/
/*
Route::get('redirect', function () {
    $data = \Request::all();
    if (isset($data['url'])) {
        return redirect($data['url']);
    } else {
        return;
    }
});
*/

$acts = [
    ['name' => 'attach'], //end act_n
    ['name' => 'detach', 'method' => ['DELETE', 'GET']], //end act_n
    ['name' => 'moveUp', 'method' => ['PUT', 'GET']],
    ['name' => 'moveDown', 'method' => ['PUT', 'GET']],
]; //end acts

$item0 = [
    'name' => '{container0}',
    'param_name' => 'item0',
    'subs' => [
        [
            'name' => '{container1}',
            'param_name' => 'item1',
            'acts' => $acts,
            'subs' => [
                [
                    'name' => '{container2}',
                    'param_name' => 'item2',
                    'acts' => $acts,
                    'subs' => [
                        [
                            'name' => '{container3}',
                            'acts' => $acts,
                            'param_name' => 'item3',
                        ], //end sub_n
                    ], //end subs
                ], //end sub_n
            ], //end subs
        ],
    ], //ens_subs
];

$item1 = [
    'name' => '{container0}',
    'param_name' => '',
    'only' => [],
    'subs' => [
        [
            'name' => 'search',
            'param_name' => 'query',
            'only' => ['index', 'show'],
        ],
        /*
        [
            'name' => 'edit',
            'only' => ['index'],
        ],
        */
       /* [
            'name' => 'map',
            'param_name' => 'query',
            'only' => ['index', 'show'],
        ],
        creato controller restaurant_map che e' la mappa dei ristoranti 
        */
    ],
];

$item2=[     //questo per avere /it/restaurant/ristotest/photo/edit
    'name' => '{container0}',
    'param_name' => 'item0',
    'subs' => [
        [
            'name' => '{container1}',
            'param_name' => '',
            'as'=>'container1.index_', 
            //'prefix'=>'ddd',
            //'prefix'=>'index_edit',
            /*
            'subs' => [
                [
                    'name'=>'Edit',
                //    'as'=>'index_edit',
                //    'prefix'=>'index_edit',
                    'only' => ['index'],
                ]
            ],//end subs
            */
            'acts'=>[
                [
                    'name'=>'Edit',
                    'act'=>'indexEdit',
                ],//end act_n
            ],//end acts
        ], //end sub_n
    ],//end subs
];//end item2


$areas_prgs = [
    $item2,
    $item1,
    $item0,
];
//,'middleware' => ['web','auth']
if ('admin' != \Request::segment(1)) { //dal backend si creano i link per il frontend ..
    //$prefix = App::getLocale();
    //$prefix=\Request::segment(1);
    $prefix= LaravelLocalization::setLocale();
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
            //RouteTrait::dynamic_route($areas_prgs);
            RouteService::dynamic_route($areas_prgs, null, $namespace);
        }
    );
}

/*-- API -- maybe move to routes/api.php or maybe i don't use it
Route::group([
    'prefix' => 'api/'.App::getLocale(),
    'middleware' => ['api','web'],
    'namespace' => $namespace.'\Api','as'=>'api.'],
    function () use ($areas_prgs){
        RouteTrait::dynamic_route($areas_prgs);
    }
);


*/
///---- without this route / go to 404
Route::group(['prefix' => null, 'middleware' => $middleware, 'namespace' => $namespace], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/redirect', 'HomeController@redirect');
    Route::get('/test01', 'HomeController@test01');
});

$this->routes();

/*
Route::fallback(function() {
    return 'Hm, why did you land here somehow?';
});

//*/
/*
 Route::get('/morph',function () {
    $risto=\XRA\Food\Models\Restaurant::find(14677);
    //ddd($risto->post_id);
    //ddd($risto->post()->toSql());
    ddd($risto->cuisineCats);
});

 
Route::get('/test01',function () {
    // var_dump(xdebug_get_function_stack());
    xdebug_print_function_stack( 'Your own message' );
}); 
*/