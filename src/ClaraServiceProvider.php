<?php
namespace CeddyG\Clara;

use Illuminate\Support\ServiceProvider;

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
        $this->publishesConfig();
		$this->publishesTranslations();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
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
