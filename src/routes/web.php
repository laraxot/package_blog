<?php
use XRA\Extend\Traits\RouteTrait;
use XRA\Extend\Services\RouteService;

$namespace=$this->getNamespace();

$namespace.='\Controllers';

$middleware=['web','guest']; //guest ti riindirizza se non sei loggato
$middleware=['web'];

$prefix='blog';
Route::get('/home', function () {
    return redirect(\App::getLocale());
});

Route::get('redirect', function () {
    $data=\Request::all();
    if(isset($data['url'])){
        return redirect($data['url']);
    }else{
        return ;
    }
});

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
    $item1,
    $item0,
];
//,'middleware' => ['web','auth']
if (\Request::segment(1)!='admin') { //dal backend si creano i link per il frontend ..
    $prefix=App::getLocale();
    //$prefix='{locale}';
    Route::group(
        [
        'prefix' => $prefix,
        'middleware' =>$middleware,
        'namespace'=>$namespace
        ],
        function () use ($areas_prgs,$namespace) {
            Route::get('/', 'HomeController@index');// different from below because this is for lang
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
Route::group(['prefix' => null,'middleware' =>$middleware,'namespace'=>$namespace], function () {
    Route::get('/', 'HomeController@index');
});


$this->routes();
