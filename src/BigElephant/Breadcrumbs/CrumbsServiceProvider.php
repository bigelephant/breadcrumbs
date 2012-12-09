<?php namespace BigElephant\Breadcrumbs;

use Illuminate\Support\ServiceProvider;

class CrumbsServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerCrumbsEvents();
	}

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
	 * Register the events needed for breadcrumbs.
	 *
	 * @return void
	 */
	protected function registerCrumbsEvents()
	{
		$app = $this->app;

		$app->after(function($request, $response) use ($app)
		{
			$crumbs = array();

			$route = $app['router']->getCurrentRoute();
			if ($route->getOption('title'))
			{
				$routeName = $route->getOption('as') ? $route->getOption('as') : md5($route->getRequirement('_method').$route->getPattern());

				$crumbs[] = array(
					'title' => $route->getOption('title'),
					'href' => $app['url']->route($routeName)
				);
			}

			if ( ! empty($app['config']['view.home_crumb']))
			{
				$homeCrumb = $app['config']['view.home_crumb'];
				if ( ! empty($homeCrumb['route']))
				{
					$homeCrumb['href'] = $app['url']->route($homeCrumb['home']);
				}
				else if ( ! empty($homeCrumb['uri']))
				{
					$homeCrumb['href'] = $app['url']->to($homeCrumb['uri']);
				}

				$crumbs[] = $homeCrumb;
			}

			$app['crumbs']->addCrumbs($crumbs);
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