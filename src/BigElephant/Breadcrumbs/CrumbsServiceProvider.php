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

		$app->before(function($request, $response) use ($app)
		{
			$crumbs = array();

			if ( ! empty($app['config']['breadcrumbs.home_crumb']))
			{
				$homeCrumb = $app['config']['breadcrumbs.home_crumb'];
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

			$route = $app['router']->getCurrentRoute();
			if ($route->getOption('title'))
			{
				$crumbs[] = array(
					'title' => $route->getOption('title'),
					'href' => $app['url']->route($route->getPattern())
				);
			}

			$app['crumbs']->addCrumbs($crumbs);
		});
	}

	protected function registerAuthEvents()
	{
		$app = $this->app;

		$app->after(function($request, $response) use ($app)
		{
			// If the authentication service has been used, we'll check for any cookies
			// that may be queued by the service. These cookies are all queued until
			// they are attached onto Response objects at the end of the requests.
			if (isset($app['auth.loaded']))
			{
				foreach ($app['auth']->getDrivers() as $driver)
				{
					foreach ($driver->getQueuedCookies() as $cookie)
					{
						$response->headers->setCookie($cookie);
					}
				}
			}
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