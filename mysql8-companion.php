<?php
/**
 * Plugin Name: MySQL 8 Companion
 * Plugin URI: http://github.com/lefred/wordpress-mysql8-companion
 * Description: If you are using MySQL 8 on prem or on cloud, this plugin will provide you useful information. The plugin also supports MySQL HeatWave on OCI
 * Version: 0.0.1
 * Plugin Prefixes: m8c, M8c, M8C, mysql8companion
 * Text Domain: mysql8-companion
 * Author: lefred
 * Author URI: https://lefred.be
 * GitHub Plugin URI: https://github.com/lefred/wordpress-mysql8-companion
 */

defined( 'WPINC' ) || die;

define( 'M8C_URL', plugin_dir_url( __FILE__ ) );
define( 'M8C_DIR', plugin_dir_path( __FILE__ ) );

require_once 'inc/bootstrap.php';

register_activation_hook( __FILE__, 'm8c_activation' );

function m8c_auto_plugin_init() {
	load_plugin_textdomain( 'mysql8-companion', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

function m8c_activation() {

	( new \M8C\PluginActivation() )::index();

}

new \M8C\AdminScreen();