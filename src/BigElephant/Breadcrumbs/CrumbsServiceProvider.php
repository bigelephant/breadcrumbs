<?php namespace BigElephant\Breadcrumbs;

use Illuminate\Support\ServiceProvider;
use BigElephant\Router;

class CrumbsServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['crumbs'] = $this->app->share(function($app)
		{
			return new Breadcrumbs;
		});

		$this->app['router'] = $this->app->share(function($app)
		{
			return new Router($app);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('crumbs');
	}
}