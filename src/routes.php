<?php

//Admin
Route::group([
    'namespace'     => config('clara.route-admin.web-admin.namespace'), 
    'prefix'        => config('clara.route-admin.web-admin.prefix'), 
    'middleware'    => config('clara.route-admin.web-admin.middleware')
], function()
{
    Route::get('/', 'CeddyG\Clara\Http\Controllers\Admin\HomeController@index')->name('admin');
    
    //App Controllers
    $aConfig = config('clara.route.admin');
    
    foreach ($aConfig as $sRoute => $sName)
    {
        Route::resource($sRoute, $sName.'Controller', ['names' => 'admin.'.$sRoute]);
    }
});

//Api admin
Route::group([
    'namespace'     => config('clara.route-admin.api.namespace'), 
    'prefix'        => config('clara.route-admin.api.prefix'), 
    'middleware'    => config('clara.route-admin.api.middleware')
], function()
{
    //Api routes for datatables and select2
    $aConfig = config('clara.route.api');
    
    foreach ($aConfig as $sRoute => $sName)
    {
        Route::get($sRoute.'/index', $sName.'Controller@index')->name('api.admin.'.$sRoute.'.index');
        Route::get($sRoute.'/select', $sName.'Controller@selectAjax')->name('api.admin.'.$sRoute.'.select');
    }
});