<?php namespace BigElephant\Breadcrumbs;

class Breadcrumbs implements \Countable, \IteratorAggregate {

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
	public function __construct(array $items = array())
	{
		$this->items = $items;
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

	public function test() { echo 'test'; }
}