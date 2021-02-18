<?php

# Core Smarty settings
$app['template']->setTemplateDir(VIEWS_PATH);
$app['template']->setCompileDir($app['config']->setting('var_path') . 'templates_c');
$app['template']->setCacheDir($app['config']->setting('var_path') . 'cache' . DS . $app['router']->controller_class . DS . $app['router']->action . DS . $app['router']->param1);
// Uncomment to enable caching
// $app['template']->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
// $app['template']->setCompileCheck(false);
$app['template']->setConfigDir(SMARTY_PATH . 'configs');

# Assign some site settings used globally
$app['template']->assign('slogan', $app['config']->setting('site_slogan'));

$route = $app['router'];
$route->build();

$app['base_controller']->parse();

if ($app['config']->setting('maintenance_mode') === "TRUE") {
	if ($app['router']->controller_class !== 'Maintenance_Controller' &&
		$app['router']->controller_class !== 'Contact_Controller') {
		header('Location: ' . $app['config']->setting('site_url') . 'maintenance');
	}
}

if ($app['config']->setting('system_startup_check') === "TRUE") {
	require_once 'system_startup_check.php';
	exit;
}
