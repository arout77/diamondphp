<?php
/**
 * file: /app/code/System/system/Factory.php
 *
 * We will use Pimple to create our services
 * and manage dependencies
 */

$app = new \Pimple\Container();

$app['global_config_import'] = function () {
	return new \App\System\Import(ENV_PATH);
};

$app['config'] = function ($c) {
	return new \App\System\Config($c['global_config_import']);
};

# Set error reporting level [via Config.php]
switch ($app['config']->setting('error_reports')) {
case "ON":
	ini_set('display_errors', 1);
	error_reporting(E_ALL & ~E_NOTICE);
	break;

case "DEV MODE":
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	break;

default:
	ini_set('display_errors', 0);
	error_reporting(0);
}

# Set log file
if ($app['config']->setting('log_errors') == "TRUE") {
	ini_set("log_errors", TRUE);
	ini_set('error_log', $app['config']->setting('log_path') . 'system.log');
}

# Set time zone [via Config.php]
date_default_timezone_set($app['config']->setting('time_zone'));

$app['router'] = function ($c) {
	return new \App\System\Router($c['config']->setting('default_controller'), $c['config']);
};

$app['database'] = function ($c) {
	return new \App\System\Database($c);
};

$app['database_info'] = function ($c) {
	$db = new \App\System\Database($c);
	return $db->sql_info($c);
};

$app['load'] = function ($c) {
	return new \App\System\Loader($c);
};

$app['log'] = function ($c) {
	return new \App\System\Logger();
};

$app['base_controller'] = function ($c) {
	return new \App\Controller\Base_Controller($c);
};

$app['system_model'] = function ($c) {
	return new \App\Model\System_Model($c['database'], $c['toolbox'], $c);
};

$app['toolbox'] = function ($app) {
	// Used to pass the toolbox as a function parameter to other objects
	return $app;
};

$app['plugin_core'] = function ($c) {
	return new \App\System\Plugins($c['config'], $c['database'], $c['toolbox'], $c['load']);
};

$app['formatter'] = function ($c) {
	return new \App\Plugin\Formatter;
};

// new geo module
$app['geoip'] = function ($c) {
	$geo_db_file = PLUGINS_PATH . 'GeoLite2-City.mmdb';
	return new \App\Plugin\Geoip($geo_db_file, $c['database']);
};

$app['hash'] = function ($c) {
	return new \App\Plugin\Hash;
};

$app['login'] = function ($c) {
	return new \App\Plugin\Login($c['config'], $c['database'], $c['toolbox'], $c['load']);
};

$app['pagination'] = function ($c) {
	return new \App\Plugin\Pagination($c);
};

$app['sanitize'] = function ($c) {
	return new \App\Plugin\Sanitize($c);
};

$app['session'] = function ($c) {
	return new \App\System\Session($c['config']);
};

$app['template'] = function ($c) {
	return new \App\System\Template($c);
};

$app['title'] = function ($app) {

	$title = new \App\Plugin\Title($app['toolbox']);
	require_once MODULES_PATH . 'Titlesettings.php';
	# Pass the Titlesettings() function from the included file above to $title->set()
	$title->set(Titlesettings($app));
	return $title;
};

$app['validate'] = function ($c) {
	return new \App\Plugin\Validation;
};

$app['whitelist'] = function ($c) {
	return new \App\Plugin\Whitelist;
};

/*

$app['cron'] = function ($c) {
return new \App\System\Cron;
};

$app['dispatcher'] = new App\System\Dispatch;

$app['registry'] = function ($c) {
return new \App\System\Registry($c);
};

$app['event'] = function ($c) {
return new \App\System\Event($c);
};

$app['system_block'] = function ($c) {
return new \App\Block\System_Block($c);
};

$app['parse'] = function ($c) {
return new \App\System\Parse($c);
};

// $app['orm'] = function ($c) {
// Create instance of redbean orm
// 	require_once VENDOR_PATH . 'gabordemooij/redbean/RedBeanPHP/R.php';
// 	return \RedBeanPHP\R::setup("mysql:host=" . $c['config']->setting('db_host') . ";
// 		dbname=" . $c['config']->setting('db_name') . "", $c['config']->setting('db_user'), $c['config']->setting('db_pass'));

// uncomment the below in production environment to prevent database columns from changing
// R::freeze( TRUE );
// };

$app['view'] = function ($c) {
return new \App\System\SystemView;
};

$app['cache'] = function ($c) {
return new \App\System\Cache;
};

$app['code_generator'] = function ($c) {
return new \App\System\Codegenerator($c);
};

#   Toolbox helpers
$app['breadcrumbs'] = function ($c) {
$bc = new \App\Plugin\Breadcrumbs($c['router'], $c['config']);
$bc->show();
return $bc;
};

$app['cookie'] = function ($c) {
return new \App\System\Cookie;
};

$app['email'] = function ($c) {
return new \App\Plugin\Email($c);
};

$app['friends'] = function ($c) {
return new \App\Plugin\Friends($c['database'], $c['toolbox'], $c['system_model']);
};

$app['image'] = function ($c) {
return new \App\Plugin\Image($c['config'], $c['toolbox']);
};

$app['input'] = function ($c) {
return new \App\Plugin\Input($c['sanitize'], $c['validate']);
};

$app['memcached'] = function ($c) {
$host            = $c['config']->setting('memcached_host');
$port            = $c['config']->setting('memcached_port');
return $instance = new \App\Plugin\Cache($host, $port);
return $instance->connect($host, $port);
if (!$connect) {
$c['log']->save('Could not connect to Memcached');}
// return $_s->connect();
};

$app['messenger'] = function ($c) {
return new \App\Plugin\Messenger($c['database'], $c['toolbox']);
};

$app['mysql'] = function ($c) {
return new \App\Plugin\Mysql($c);
};

$app['opcache'] = function ($c) {
return new \App\System\Opcache;
};

$app['performance'] = function ($c) {
return new \App\Plugin\Performance;
};

$app['search'] = function ($c) {
return new \App\Plugin\Search($c['database']);
};
 */
