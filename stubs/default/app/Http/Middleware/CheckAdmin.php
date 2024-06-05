<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user       = Auth::user();
        $allRoutes  = Arr::where(Route::getRoutes()->getRoutesByName(), function ($value, $key) {
            return Str::is('admin.*', $key);
        });
        
        foreach ($allRoutes as $routeName => $route) {
            if ($user->permissions) {
                foreach ($user->permissions as $permission => $value) {
                    if (Str::is($permission, $routeName) || Str::is($routeName, $permission)) {
                        Gate::define($routeName, function (User $user) use ($value) {
                            return $value;
                        });
                    }
                }
            }

            foreach ($user->roles as $role) {
                if ($user->permissions) {
                    foreach ($role->permissions as $permission => $value) {
                        if (Str::is($permission, $routeName) || Str::is($routeName, $permission)) {
                            Gate::define($routeName, function (User $user) use ($value) {
                                return $value;
                            });
                        }
                    }
                }
            }
        }

        if (!Gate::allows(Route::currentRouteName())) {
            abort(403);
        }
        
        return $next($request);
    }
}
