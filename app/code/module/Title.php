<?php
namespace App\Module;

class Title
{
	/**
	 * @var mixed
	 */
	private $route;
	/**
	 * @var mixed
	 */
	public $controller;
	/**
	 * @var mixed
	 */
	public $action;
	/**
	 * @var mixed
	 */
	public $title;
	/**
	 * @var mixed
	 */
	public $default_title;

	/**
	 * @param $c
	 */
	public function __construct($c)
	{
		$this->route         = $c['router'];
		$this->controller    = $this->route->controller_class;
		$this->action        = $this->route->action;
		$this->default_title = (!empty($c['config']->setting['site_slogan']) ? $c['config']->setting['site_slogan'] : $c['config']->setting['site_name']);
	}

	/**
	 * @return mixed
	 */
	public function get()
	{
		return $this->title;
	}

	/**
	 * @param array $titles
	 * @return mixed
	 */
	public function set(Array $titles)
	{
		foreach ($titles as $controller => $title)
		{
			if (in_array($controller, [$this->controller]))
			{
				if (!is_null($this->action) && isset($title[$this->action]) && !empty($this->action))
				{
					return $this->title = $title[$this->action];
					exit;
				}
				else
				{
					return $this->title = $this->default_title;
					exit;
				}
			}
			continue;
		}
		return $this->title = $this->default_title;
	}

}
