<?php

/**
 * @package MySQL8_Companion
 * @version 1.0.0
 */

namespace M8C;

class AdminScreen
{
	public function __construct()
	{
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueues'));
		add_action('admin_menu', array($this, 'admin_menu'));
		add_action('wp_dashboard_setup', array($this, 'admin_m8c_add_dashboard_widgets'));
        add_action('wp_enqueue_script', 'ajax_m8c_statements' );
        add_action('wp_ajax_m8c_get_statement_details', [$this, 'm8c_get_statement_details'] );
        add_action('wp_enqueue_script', 'ajax_m8c_qep' );
        add_action('wp_ajax_m8c_get_qep_details', [$this, 'm8c_get_qep_details'] );
	}

	public function m8c_get_statement_details()
	{
		check_ajax_referer('m8c_statements', 'nonce', true);
        $pfs_det = array();
		// find all information for that query
        global $wpdb;
        
		$query = "SELECT query, t1.digest, query_sample_text,
			  rows_sent, rows_sent_avg, rows_examined, rows_examined_avg,
				  exec_count, format_pico_time(max_latency) max_latency,
				  sum_created_tmp_disk_tables,
				  sum_created_tmp_tables, sum_select_full_join, 
				  sum_select_full_range_join, sum_select_range, sum_select_scan,
				  sum_sort_rows, sum_sort_scan, sum_no_index_used,
				  format_bytes(t1.max_total_memory) max_total_memory
                  FROM sys.x\$statement_analysis AS t1   
                  JOIN performance_schema.events_statements_summary_by_digest AS t2      
                    ON t2.digest=t1.digest   
                 WHERE t1.digest='". $_POST['digest'] ."';";
        $variables = $wpdb->get_results($query);
		foreach( $variables[0] as $variable => $value ) {
            $pfs_det[$variable] = wp_kses( $value, 'strip' );
        }
        
		wp_send_json([
			"data" => $pfs_det 
		]);
        wp_die();
	}

	public function m8c_get_qep_details()
	{
		check_ajax_referer('m8c_qep', 'nonce', true);
        $pfs_query = array();
        $pfs_qep = array();
		// find all information for that query
        global $wpdb;
        
		$query = " SELECT query_sample_text 
					  FROM performance_schema.events_statements_summary_by_digest
					 WHERE digest='" . $_POST['digest'] . "';";
  
		$variables = $wpdb->get_results($query);		
		foreach( $variables[0] as $variable => $value ) {
			$pfs_query[$variable] = $value;
		}	     
		if (str_ends_with($pfs_query['query_sample_text'], '...')) {
			$pfs_qep["EXPLAIN"]='Sample text truncated !';
		} else { 
			$query = "EXPLAIN format=json " . $pfs_query['query_sample_text'];
        	$variables = $wpdb->get_results($query);		
			$pfs_qep['query_cost'] = $variables[0];

			$query = "EXPLAIN format=tree " . $pfs_query['query_sample_text'];
        	$variables = $wpdb->get_results($query);		
			foreach( $variables[0] as $variable => $value ) {
            	$pfs_qep[$variable] = wp_kses( $value, 'strip' );
        	}
		}      

		wp_send_json([
			"data" => $pfs_qep
		]);
        wp_die();
	}


	public function admin_enqueues()
	{
		wp_enqueue_style('m8c-styles', m8c_url('/css/styles.css'), array(), false, 'all');
		wp_enqueue_script('m8c--statement-script', m8c_url('js/statements.js'), array('jquery'), false, true );
		wp_enqueue_script('m8c--qep-script', m8c_url('js/qep.js'), array('jquery'), false, true );
		wp_add_inline_script('m8c--statement-script', 'const m8cstatements = ' . json_encode([
			'dir' => plugin_dir_path(__DIR__),
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('m8c_statements'),
		]), 'before');
		wp_add_inline_script('m8c--qep-script', 'const m8cqep = ' . json_encode([
			'dir' => plugin_dir_path(__DIR__),
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('m8c_qep'),
		]), 'before');

	}

	public function admin_menu()
	{
/*
		add_submenu_page(
			'tools.php',
			'MySQL 8 Companion',
			'MySQL 8 Companion',
			'manage_options',
			'm8c',
			array($this, 'admin_screen_template')
		);
*/
		add_menu_page(
			'MySQL 8 Companion',
			'MySQL 8 Companion',
			'manage_options',
			'm8c',
			array($this, 'admin_screen_template'),
			'dashicons-database',
			99	
		);
	}

	public function admin_screen_template()
	{

		m8c__template('templates/admin/main');
	}

	/**
	 * Add a widget to the dashboard.
	 *
	 * This function is hooked into the 'wp_dashboard_setup' action below.
	 */
	function admin_m8c_add_dashboard_widgets()
	{

		wp_add_dashboard_widget(
			'mysql8_companion_widget',
			esc_html__('MySQL 8 Companion', 'MySQL 8 Companion'),
			'mysql8_companion_widget_render'
		);
	}
}
