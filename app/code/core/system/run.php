<?php

<<<<<<< HEAD
if ($app['config']->setting('debug_mode') == 'ON' || $app['config']->setting('debug_mode') == 'on') {
	// Start the timer for script exec time profiler
	$profiler = new App\System\Profiler($app['config'], $app['database'], $app['plugin_core'], $app['load']);
	$profiler->start_timer();
}

=======
>>>>>>> ec5adaa9c1057104c796a0bef4746beb58a29024
# Core Smarty settings
$app['template']->setTemplateDir(VIEWS_PATH);
$app['template']->setCompileDir($app['config']->setting('var_path') . 'templates_c');
$app['template']->setCacheDir($app['config']->setting('var_path') . 'cache' . DS . $app['router']->controller_class . DS . $app['router']->action . DS . $app['router']->param1);
// Uncomment to enable caching
// $app['template']->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
// $app['template']->setCompileCheck(false);
$app['template']->setConfigDir(SMARTY_PATH . 'configs');

# Assign some site settings used globally
<<<<<<< HEAD
$app['template']->assign('site_url', $app['config']->setting('site_url'));
$app['template']->assign('site_name', $app['config']->setting('site_name'));
=======
>>>>>>> ec5adaa9c1057104c796a0bef4746beb58a29024
$app['template']->assign('slogan', $app['config']->setting('site_slogan'));

$route = $app['router'];
$route->build();

$app['base_controller']->parse();

if ($app['config']->setting('maintenance_mode') === "TRUE") {
	if ($app['router']->controller_class !== 'Maintenance_Controller' &&
		$app['router']->controller_class !== 'Contact_Controller') {
		header('Location: ' . $app['config']->setting('site_url') . 'maintenance');
	}
<<<<<<< HEAD
}

if ($app['config']->setting('system_startup_check') === "TRUE") {
	require_once 'system_startup_check.php';
	exit;
}

if ($app['config']->setting('debug_mode') == 'ON' || $app['config']->setting('debug_mode') == 'on') {
	// Stop the timer for script exec time profiler
	$profiler->stop_timer();

	if ((round($profiler->ram_usage() / 1024)) <= 1023) {
		$ram_usage = round($profiler->ram_usage() / 1024) . ' kb';
	} else {
		$ram_usage = round($profiler->ram_usage() / 1024 / 1024, 2) . ' MB';
	}

	if ((round($profiler->ram_peak_usage() / 1024)) <= 1023) {
		$ram_peak_usage = round($profiler->ram_peak_usage() / 1024) . ' kb';
	} else {
		$ram_peak_usage = round($profiler->ram_peak_usage() / 1024 / 1024, 2) . ' MB';
	}

	$sql = $profiler->get_sql();
	// var_dump($sql);exit;

	$app['template']->assign('exec_time', $profiler->timer());
	$app['template']->assign('ram_usage', $ram_usage);
	$app['template']->assign('ram_peak_usage', $ram_peak_usage);
	$app['template']->display('template/debug_toolbar.tpl');
=======
}

if ($app['config']->setting('system_startup_check') === "TRUE") {
	require_once 'system_startup_check.php';
	exit;
>>>>>>> ec5adaa9c1057104c796a0bef4746beb58a29024
}
