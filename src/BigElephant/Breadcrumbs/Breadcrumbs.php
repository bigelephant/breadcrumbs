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
	 * Get a new breadcrumbs instance.
	 *
	 * @param  array  $items
	 */
	public function make(array $items)
	{
		return new self($items);
	}

	/**
	 * Add a crumb, is chainable.
	 *
	 * @param string 	title
	 * @param string 	href
	 * @param array 	optons
	 *
	 * @return BigElephant\Breadcrumbs\Breadcrumbs
	 */
	public function add($title, $href, array $options = array())
	{
		$this->crumbs[count($this->crumbs) - 1]['active'] = false;

		$this->crumbs[] = array(
			'title' => $title,
			'href' => $href,
			'active' => true
		);

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