<?php
namespace CeddyG\Clara;

use Illuminate\Support\ServiceProvider;

use View;
use Event;
use Route;
use Sentinel;
use Navigation;

/**
 * Description of EntityServiceProvider
 *
 * @author CeddyG
 */
class ClaraServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->adminSidebar();
        $this->publishesConfig();
		$this->publishesTranslations();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->subscribeEvent();
    }
    
    private function adminSidebar()
    {
        View::composer('admin.sidebar', function($view)
        {
            $sRoute     = Route::getCurrentRoute()->getName();
            $aAction    = explode('.', $sRoute);
            $sEntity    = isset($aAction[1]) ? $aAction[1] : '';
            
            $aConfigNavbar = config('clara.navbar', []);
            $aNavbar = [];
            
            foreach ($aConfigNavbar as $sKey => $mTitle)
            {
                if (Sentinel::hasAccess('admin.'.$sKey.'.index') && Route::has('admin.'.$sKey.'.index'))
                {
                    $aNavbar[] = [
                        'title' => strpos($mTitle, '.') !== false ? __($mTitle) : $mTitle, 
                        'link'  => route('admin.'.$sKey.'.index'), 'active' => $sEntity == $sKey
                    ];
                }
                
                if (is_array($mTitle))
                {
                    $aSubNav = [];
                    
                    foreach ($mTitle[1] as $sSubKey => $sSubTitle)
                    {
                        if (Sentinel::hasAccess('admin.'.$sSubKey.'.index') && Route::has('admin.'.$sSubKey.'.index'))
                        {
                            $aSubNav[] = [
                                'title' => strpos($sSubTitle, '.') !== false ? __($sSubTitle) : $sSubTitle,
                                'link' => route('admin.'.$sSubKey.'.index'), 'active' => $sEntity == $sSubKey
                            ];
                        }
                    }
                    
                    if (count($aSubNav) > 0)
                    {
                        $sMainTitle = strpos($mTitle[0], '.') !== false ? __($mTitle[0]) : $mTitle[0];

                        $aNavbar[] = [
                            $sMainTitle, 
                            $aSubNav
                        ];
                    }
                }
            }
            
            $aNavbarParam = [];
            
            if (Sentinel::hasAccess('admin.user.index') && Route::has('admin.user.index'))
            {
                if (Sentinel::hasAccess('admin.group.index') && Route::has('admin.group.index'))
                {
                    $aNavbarParam[] = [
                        'Utilisateurs',
                        [
                            ['title' => 'Liste', 'link' => URL('admin/user'), 'active' => $sEntity == 'user'],
                            ['title' => 'Groupes', 'link' => URL('admin/group'), 'active' => $sEntity == 'group']
                        ]
                    ];
                }
                else
                {
                    $aNavbarParam[] = ['title' => 'Utilisateurs', 'link' => URL('admin/user'), 'active' => $sEntity == 'user']                    ;
                }
            }
            
            if (Sentinel::hasAccess('admin.lang.index') && Route::has('admin.lang.index'))
            {
                $aNavbarParam[] = ['title' => __('clara-lang::lang.language'), 'link' => URL('admin/language'), 'active' => $sEntity == 'lang'];
            }
            
            if (Sentinel::hasAccess('admin.dataflow.index') && Route::has('admin.dataflow.index'))
            {
                $aNavbarParam[] = ['title' => 'Dataflow', 'link' => URL('admin/dataflow'), 'active' => $sEntity == 'dataflow'];
            }
            
            if (Sentinel::hasAccess('admin.parameter.index') && Route::has('admin.parameter.index'))
            {
                $aNavbarParam[] = ['title' => __('clara-parameter::parameter.parameter'), 'link' => URL('admin/parameter'), 'active' => $sEntity == 'parameter'];
            }
            
            if (Sentinel::hasAccess('clara-entity.index') && Route::has('clara-entity.index'))
            {
                $aNavbarParam[] = ['title' => 'Entity', 'link' => URL('admin/clara-entity'), 'active' => $sEntity == 'clara-entity'];
            }
            
            $sNavbar        = Navigation::pills($aNavbar, ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'])->stacked();
            $sNavbarParam   = Navigation::pills($aNavbarParam, ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'])->stacked();
            
            $view->with('navbar', $sNavbar);
            $view->with('navbarparam', $sNavbarParam);
        });
    }
	
    /**
	 * Publish config file.
	 * 
	 * @return void
	 */
	private function publishesConfig()
	{
		$sConfigPath = __DIR__ . '/../config';
        if (function_exists('config_path')) 
		{
            $sPublishPath = config_path();
        } 
		else 
		{
            $sPublishPath = base_path();
        }
		
        $this->publishes([$sConfigPath => $sPublishPath], 'clara.config');  
	}
	
	private function publishesTranslations()
	{
		$sTransPath = __DIR__.'/../resources/lang';

        $this->publishes([
			$sTransPath => resource_path('lang/vendor/clara'),
			'clara.trans'
		]);
        
		$this->loadTranslationsFrom($sTransPath, 'clara');
    }
    
    private function subscribeEvent()
    {
        $aSubscriber = config('clara.subscriber', []);
        
        foreach ($aSubscriber as $sSubscriber)
        {
            Event::subscribe($sSubscriber);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.php', 'clara'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.route.admin.php', 'clara.route.admin'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.route.api.php', 'clara.route.api'
        );    
    }
}
