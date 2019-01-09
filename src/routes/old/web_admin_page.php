<?php

use XRA\Extend\Traits\RouteTrait;

$namespace=$this->getNamespace().'\Controllers\Admin';
//$pack= class_basename($this->getNamespace());
$pack='Page';
$pack_low=strtolower($pack);


$item0=[
    'name'=>$pack_low,
    'prefix'=>$pack_low,
    'as'=>$pack_low.'.',
    'namespace'=>null,
    'controller' =>  $pack.'Controller',
    //'only'=>['index','show'],
];

$areas_prgs=[
    $item0
];
//,'middleware' => ['web','auth']
$prefix=App::getLocale();
//$prefix='{locale}';
Route::group(['prefix' => 'admin','namespace'=>$namespace], function () use ($areas_prgs) {
    RouteTrait::dynamic_route($areas_prgs);
});
