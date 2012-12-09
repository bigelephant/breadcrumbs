<?php namespace BigElephant\Breadcrumbs;

use IteratorAggregate;
use ArrayIterator;
use Countable;

class Breadcrumbs implements Countable, IteratorAggregate {

	/**
	 * The array of crumbs.
	 *
	 * @var array
	 */
	protected $crumbs;

	/**
	 * Create a new Breadcrumbs instance.
	 *
	 * @param  array  $items
	 * @return void
	 */
	public function __construct(array $crumbs = array())
	{
		$this->crumbs = $crumbs;
	}

	/**
	 * Get a new breadcrumbs instance.
	 *
	 * @param  array  $items
	 */
	public function make(array $items)
	{
		return new self($items);
	}

	/**
	 * Get own instance, mainly for the laravel facade.
	 *
	 * @return BigElephant\Breadcrumbs\Breadcrumbs
	 */
	public function get()
	{
		return $this;
	}

	/**
	 * Add a crumb, is chainable.
	 *
	 * @param string title
	 * @param string href
	 *
	 * @return BigElephant\Breadcrumbs\Breadcrumbs
	 */
	public function add($title, $href)
	{
		foreach ($this->crumbs AS &$crumb)
		{
			$crumb['active'] = false;
		}

		$this->crumbs[] = array(
			'title' => $title,
			'href' => $href,
			'active' => true,
		);

		return $this;
	}

	public function prepend($title, $href)
	{
		array_unshift($this->crumbs, array(
			'title' => $title,
			'href' => $href
		));

		return $this;
	}

	public function prependCrumbs(array $crumbs)
	{
		return $this->addCrumbs($crumbs, true);
	}

	/**
	 * Add a bunch of crumbs.
	 *
	 * @param array crumbs
	 *
	 * @return BigElephant\Breadcrumbs\Breadcrumbs
	 */
	public function addCrumbs(array $crumbs, $prepend = false)
	{
		$method = $prepend ? 'prepend' : 'add';

		foreach ($crumbs AS $crumb)
		{
			$this->$method($crumb['title'], $crumb['href']);
		}

		return $this;
	}

	/**
	 * Get an iterator for the crumbs.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->crumbs);
	}

	/**
	 * Count the number of crumbs.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->crumbs);
	}
}