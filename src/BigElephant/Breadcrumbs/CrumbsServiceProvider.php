<?php namespace BigElephant\Breadcrumbs;

use Illuminate\Support\ServiceProvider;
use BigElephant\Routing;

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

		$crumb = $this->app->config['view.home_crumb'];
		if ( ! empty($crumb))
		{
			if ( ! empty($crumb['route']))
			{
				$crumb['href'] = $this->app->url->route($crumb['home']);
			}
			else if ( ! empty($crumb['uri']))
			{
				$crumb['href'] = $this->app->url->to($crumb['uri']);
			}

			$this->app->add($crumb['title'], $crumb['href']);
		}
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