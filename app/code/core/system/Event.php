<?php
namespace App\System;

class Event extends \Symfony\Component\EventDispatcher\Event
{
	/**
	 * @var mixed
	 */
	protected $dispatcher;

	/**
	 * @param $app
	 */
	public function __construct($app)
	{
		$this->dispatcher = $app['dispatcher'];
	}

	/**
	 * @param $name
	 * @param $class
	 * @param $callback
	 */
	public function _register($name, $class, $callback)
	{
		$this->dispatcher->addListener("{$name}", array($class, $callback));
	}

}