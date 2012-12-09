<?php namespace BigElephant\Breadcrumbs;

use Illuminate\Support\ServiceProvider;

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