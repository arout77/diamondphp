<?php
namespace App\System;
use \PDO as PDO;

class Database extends PDO
{
	/**
	 * @var mixed
	 */
	public $sql;

	/**
	 * @param $c
	 */
	public function __construct($c)
	{
		parent::__construct("mysql:host=" . $c['config']->setting('db_host') . ";dbname=" . $c['config']->setting('db_name') . "", $c['config']->setting('db_user'), $c['config']->setting('db_pass'));
		PDO::setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		PDO::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}
