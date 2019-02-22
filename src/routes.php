<?php

//Admin
Route::group([
    'namespace'     => config('clara.route.web-admin.namespace'), 
    'prefix'        => config('clara.route.web-admin.prefix'), 
    'middleware'    => config('clara.route.web-admin.middleware')
], function()
{
    Route::get('/', 'HomeController@index')->name('admin');
    
    //App Controllers
    $aConfig = config('clara.route.admin');
    
    foreach ($aConfig as $sRoute => $sName)
    {
        Route::resource($sRoute, $sName.'Controller', ['names' => 'admin.'.$sRoute]);
    }

    Route::resource('user', 'UserController', ['names' => 'admin.user']);
    Route::resource('group', 'RoleController', ['as' => 'admin']);
});

//Api admin
Route::group([
    'namespace'     => config('clara.route.api.namespace'), 
    'prefix'        => config('clara.route.api.prefix'), 
    'middleware'    => config('clara.route.api.middleware')
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