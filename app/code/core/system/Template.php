<?php

namespace App\System;
use Smarty;

if (!class_exists('Smarty'))
{
	require SMARTY_PATH . 'libs/Smarty.php';
}

class Template extends Smarty
{
	/**
	 * @var mixed
	 */
	public $app;
	/**
	 * @var mixed
	 */
	protected $config;
	/**
	 * @var mixed
	 */
	protected $load;
	/**
	 * @var mixed
	 */
	protected $route;
	/**
	 * @var mixed
	 */
	public $session;
	# Is this the admin area?
	/**
	 * @var mixed
	 */
	private $is_admin = FALSE;

	/**
	 * @param $app
	 */
	public function __construct($app)
	{
		parent::__construct();

		$this->config = $app['config'];
		$this->load   = $app['load'];
		$this->route  = $app['router'];

		if ($this->route->controller == 'Admin')
		{
			$this->is_admin = TRUE;
		}
	}
}
