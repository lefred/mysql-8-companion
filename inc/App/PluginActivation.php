<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.2
 */

namespace M8C;

class PluginActivation
{

	public function __construct()
	{

	}

	public static function index()
	{

		self::create_versions_table();

	}

	private static function create_versions_table()
	{

		$table_contents_file = m8c_dir('static/table-mysql_versions-structure.sql');

		if (!file_exists($table_contents_file)) return;

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$vars = array(
			'%%VAR_PREFIX%%' => $wpdb->prefix,
			'%%VAR_CHARACTER%%' => $charset_collate,
		);

		$sql = file_get_contents($table_contents_file);
		$sql = str_replace(array_keys($vars), array_values($vars), $sql);

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);

		self::insert_versions_data();

	}

	private static function insert_versions_data()
	{

		$table_contents_file = m8c_dir('static/table-mysql_versions-data.sql');

		if (!file_exists($table_contents_file)) return;

		global $wpdb;

		$table_name = $wpdb->prefix . 'mysql_versions';

		$record = $wpdb->get_var("SELECT COUNT(*) from $table_name where id = 1");

		// print_r($record);exit;

		if ($record) return;

		$charset_collate = $wpdb->get_charset_collate();

		$vars = array(
			'%%VAR_PREFIX%%' => $wpdb->prefix,
		);

		$sql = file_get_contents($table_contents_file);
		$sql = str_replace(array_keys($vars), array_values($vars), $sql);

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);

	}

}
?>
