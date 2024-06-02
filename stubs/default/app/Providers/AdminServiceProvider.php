<?php

namespace App\Providers;

use App\Http\Middleware\CheckAdmin;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            Route::middleware(['web', CheckAdmin::class])
                ->prefix('admin')
                ->name('admin.')
                ->namespace('App\\Http\\Controllers\\Admin')
                ->group(base_path('routes/admin.php'));
        });
        
        $this->setPermissionsInView();
    }
    
    private function setPermissionsInView()
    {
        View::composer('admin.users.form', function($view)
        {            
            $view->with('permissions', self::getPermissions());
        });
        
        View::composer('admin.roles.form', function($view)
        {            
            $view->with('permissions', self::getPermissions());
        });
    }
    
    public static function getPermissions()
    {
        $allRoutes  = Arr::where(Route::getRoutes()->getRoutesByName(), function ($value, $key) {
            return Str::is('admin.*', $key);
        });
        
        $permissions = [];
        $currentPerm = '';
        
        foreach($allRoutes as $name => $route)
        {
            $name       = str_replace('admin.', '', $name);
            $tmpName    = explode('.', $name);
            
            if($currentPerm != $tmpName[0] && $tmpName[0] != 'admin') {
                $permissions['admin.'.$tmpName[0].'.*'] = $tmpName[0];
                
                $currentPerm = $tmpName[0];
            }

            $name = str_replace('.', ' ', $name);
            
            $permissions[$route->getName()] = $name;
        }
        
        asort($permissions);
        $permissions = ['*' => 'all'] + $permissions;
        
        return $permissions;
    }
}
