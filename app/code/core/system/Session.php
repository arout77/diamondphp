<?php
namespace App\System;

session_start();

class Session
{
	/**
	 * @var mixed
	 */
	public $id;
	/**
	 * @var array
	 */
	public $errors = [];
	/**
	 * @var mixed
	 */
	private $config;

	/**
	 * @param $config
	 */
	public function __construct($config)
	{

		$this->config = $config;

		if (empty($this->id))
		{
			self::start();
		}
	}

	/*--------------------------------------------
		 *	Session handling functions
	*/
	public function data()
	{
		$data = $_SESSION;

		if (!empty($data))
		{
			echo '<div class="console"><h3>Current Session Information</h3>';
			echo '<table class="table"><th>Session Key</th><th>Value</th>';

			foreach ($data as $key => $value)
			{
				echo '<tr><td><strong>' . $key . ':</strong></td><td>' . $value . '</td></tr>';
			}

			echo '</table></div>';
		}
		else
		{
			echo '<div class="console"><h3>No Session Information Available</h3></div>';
		}

	}

	/**
	 * @param $key
	 */
	public function delete($key)
	{
		# Delete single item from $_SESSION
		$data = $_SESSION[$key];
		session_unset($data);
	}

	public function flush()
	{
		# Destroy entire session
		self::start();
		$this->id = FALSE;
		session_unset();

		return session_destroy();
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	public function get($key)
	{
		if (isset($_SESSION["$key"]))
		{
			return $_SESSION["$key"];
		}
		else
		{
			return FALSE;
		}

	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function set($key, $value)
	{
		return $_SESSION["$key"] = $value;
	}

	public function start()
	{
		if (empty($this->id))
		{
			session_start([
				'cache_limiter'   => $this->config->setting('session.cache_limiter'),
				'cookie_domain'   => $this->config->setting('session.cookie_domain'),
				'cookie_httponly' => $this->config->setting('session.cookie_httponly'),
				'cookie_lifetime' => $this->config->setting('session.cookie_lifetime'),
				'use_strict_mode' => $this->config->setting('session.use_strict_mode'),
			]);
			$this->id = session_regenerate_id();
		}
	}

	/**
	 * @param $key
	 */
	public function verify($key)
	{
		if (isset($_SESSION[$key]))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}

}
