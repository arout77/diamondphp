<?php
namespace Hal\Model;

class System_Model
{
	protected $block;
	protected $db;
	protected $config;
	public $session;
	public $cache;
	// Data accessed by views / controllers
	public $data;
	public $hash;
	public $load;
	protected $toolbox;

	public function __construct($db, $toolbox, $config)
	{
		$this->db      = $db;
		$this->config  = $config;
		$this->toolbox = $toolbox;
		$this->session = self::session();
		//$this->hash         = self::hash();
		$this->cache = self::cache();
	}

	public function cache()
	{
		// return \Application::run('Cache');
	}

	public function encrypt($string)
	{
		# Encrypt using password_hash()
		$hash = new \Hal\Module\Hash;
		return $hash->encrypt($string);
	}

	public function verify($string, $base)
	{
		# Decrypt hash from encrypt()
		$hash = new \Hal\Module\Hash;
		return $hash->verify($string, $base);
	}

	public function session()
	{
		return $this->toolbox["session"];
	}

	public function toolbox($helper)
	{
		# Load a Toolbox helper
		return $this->toolbox["$helper"];
	}

}