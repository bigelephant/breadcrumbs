<?php namespace BigElephant\Routing;

use Illuminate\Routing;
use Illuminate\Routing\Router as BaseRouter;
use Symfony\Component\HttpFoundation\Request;

class Router extends BaseRouter {

	/**
	 * Create a new router instance.
	 *
	 * @param  Illuminate\Container  $container
	 * @return void
	 */
	public function __construct(Container $container = null)
	{
		parent::__construct($container);

		if ( ! empty($container['config']['view.home_crumb']))
		{
			$homeCrumb = $container['config']['view.home_crumb'];
			if ( ! empty($homeCrumb['route']))
			{
				$homeCrumb['href'] = $container['url']->route($homeCrumb['home']);
			}
			else if ( ! empty($homeCrumb['uri']))
			{
				$homeCrumb['href'] = $container['url']->to($homeCrumb['uri']);
			}

			$container['crumbs']->addCrumbs(array($homeCrumb));
		}
	}

	/**
	 * Set the attributes and requirements on the route.
	 *
	 * @param  Illuminate\Routing\Route  $route
	 * @param  array  $action
	 * @param  array  $optional
	 * @return void
	 */
	protected function setAttributes(Route $route, $action, $optional)
	{
		parent::setAttributes($route, $action, $optional);

		if (isset($action['title']))
		{
			$route->setOptional('title', $action['title']);
		}

		if (isset($action['as']))
		{
			$route->setOptional('as', $action['as']);
		}
	}

	/**
	 * Get the response for a given request.
	 *
	 * @param  Symfony\Component\HttpFoundation\Request  $request
	 * @return Symfony\Component\HttpFoundation\Resonse
	 */
	public function dispatch(Request $request)
	{
		$this->currentRequest = $request;

		// First we will call the "before" global middlware, which we'll give a chance
		// to override the normal requests process when a response is returned by a
		// middleware. Otherwise we'll call the route just like a normal request.
		$response =  $this->callGlobalFilter($request, 'before');

		if ( ! is_null($response))
		{
			return $this->prepare($response, $request);
		}

		$this->currentRoute = $route = $this->findRoute($request);

		// We need to setup the route crumbs here if applicable
		$this->setupRouteCrumb($route);

		// Once we have the route, we can just run it to get the responses, which will
		// always be instances of the Response class. Once we have the responses we
		// will execute the global "after" middlewares to finish off the request.
		$response = $route->run($request);

		$this->callAfterFilter($request, $response);

		return $response;
	}

	public function setupRouteCrumb(Route $route)
	{
		if ($route->getOption('title'))
		{
			$routeName = $route->getOption('as') ? $route->getOption('as') : md5($route->getRequirement('_method').$route->getPattern());

			$this->container['crumbs']->add($route->getOption('title'), $this->container['url']->route($routeName));
		}
	}
}