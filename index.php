<?php
// MIT License

// Copyright (c) 2021 Andrew Rout

// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.

/**
 * An open source application development framework designed for PHP 7
 *
 * @package         Diamond PHP Framwework
 * @author          Andrew Rout [ arout@diamondphp.org ]
 * @copyright       Copyright (c) 2021, Andrew Rout
 * @license         https://diamondphp.org/support/license
 * @link            https://diamondphp.org
 * @since           Version 1.0.0
 * @filesource
 *
 */
declare (strict_types = 1);

define('DS', DIRECTORY_SEPARATOR);

// Defines the location of the front controller (this file)
// For security purposes, we recommend the front controller
// to be the only PHP file stored in a publicly accessible folder
if (!defined('BASE_PATH')) {
	$dir = getcwd();
	$dir = chop($dir);
	$dir = chop($dir, "/");
	define('BASE_PATH', $dir . DS);
}

// If you moved your .env file to another directory,
// remove BASE_PATH . below and enter the full file path
define('ENV_PATH', BASE_PATH . '.env');
$file = ENV_PATH;

// Check for and attempt to fix read permissions to the .env file
// Will not work on all servers
$fp = fileperms($file);
if (file_exists($file)) {
	if (substr(sprintf('%o', $fp), -4) != 0644) {
		chmod($file, 0644);
	}
}

// Either the $file variable above is set incorrectly,
// or we just cannot read the file. Alert user and abort.
if (!is_readable($file)) {
	exit('<h3>Either the <span style="color: red;">.env</span> global configuration file was not found,
		or does not have read permissions. Exiting...</h3>');
}
unset($file);
unset($fp);

require_once BASE_PATH . 'vendor' . DS . 'autoload.php';

// If installed in a subdirectory, enter name of subdirectory
// folder here. Otherwise, leave blank
$subdir = '';

// Import service locator
require_once BASE_PATH . 'app' . DS . 'code' . DS . 'core' . DS . 'system' . DS . 'Factory.php';

// Load path definitions
require_once $app['config']->setting('system_path') . 'Paths.php';

// Start session. Be sure to only make changes to session options
// within the .env configuration file.
$app['session']->start();

// Ready...steady...go!
require_once $app['config']->setting('system_path') . 'Run.php';
