<?php
/**
 * @package MySQL8_Companion
 * @version 0.0.2
 */

defined('WPINC') || die;

/**
 * Get the plugin directory path
 *
 * @param boolean $append Append a file to the path
 * @return string
 */
function m8c_dir($append = false)
{

	return M8C_DIR . $append;

}

/**
 * Get the plugin directory URL
 *
 * @param boolean $append Append to the plugin directory URL
 * @return string
 */
function m8c_url($append = false)
{

	return M8C_URL . $append;

}

/**
 * Include a file(s)
 *
 * @param string|array $inc File path or Array of file paths
 * @param array $args Arguments to pass to the file
 * @param boolean $once Include once or not
 * @return void
 */
function m8c_inc($file, $args = array(), $once = false)
{

	$includes = is_array($file) ? $file : array($file);
	$base_dir = m8c_dir();

	if (is_array($args) && count($args) > 0) {

		extract($args);

	}

	foreach ($includes as $include) {

		$include = $base_dir . $include;

		!$once ?
			include $include :
			include_once $include;

	}

}

m8c_inc(array(
	'vendor/autoload.php',
	'inc/constants.php',
	'inc/functions.php',
	'inc/hooks.php',
));
