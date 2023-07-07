<?php
    $m8c_gd_mem = $m8c_GeneralData->getMemAll();
    $m8c_gd_uptime = $m8c_GeneralData->getUptime();
    $m8c_gd_laststartup = $m8c_GeneralData->getLastStartup();
?>
<div class="m8c-grid">
<fieldset class="m8c">
  <legend>General</legend> 
  <table>
	<?php
	    m8c_variable_entry( $m8c_gd['version_comment'] . " " . $m8c_gd['version'], "MySQL Version", "version_comment","dashicons-database");
	    m8c_variable_entry( $m8c_gd['version_compile_os'], "OS", "version_compile_os","dashicons-admin-generic");
	    m8c_variable_entry( $m8c_gd['version_compile_machine'], "Architecture", "version_compile_machine","dashicons-admin-tools");
	    m8c_variable_entry( $m8c_gd['hostname'], "Hostname", "hostname","dashicons-admin-site");
	?>
  </table>
</fieldset>
<?php
	if( isset( $m8c_gd['sql_generate_invisible_primary_key'] ) ) {
?>
<fieldset class="m8c">
  <legend>GIPK Mode</legend> 
  <table>
	<?php
	    m8c_variable_entry( $m8c_gd['sql_generate_invisible_primary_key'], "Auto Primary Key", "sql_generate_invisible_primary_key","dashicons-welcome-learn-more");
	    m8c_variable_entry( $m8c_gd['show_gipk_in_create_table_and_information_schema'], "Visible in CREATE TABLE and Information_Schema", "show_gipk_in_create_table_and_information_schema","dashicons-welcome-learn-more");
	?>
  </table>
</fieldset>
<?php
	}
?>

<fieldset class="m8c">
  <legend>Network</legend> 
  <table>
	<?php
	    m8c_variable_entry( $m8c_gd['bind_address'], "Bind Address", "bind_address","dashicons-networking");
	    m8c_variable_entry( $m8c_gd['port'], "Port", "port","dashicons-networking");
	    m8c_variable_entry( $m8c_gd['admin_address'], "Admin Address", "admin_address","dashicons-networking");
	    m8c_variable_entry( $m8c_gd['admin_port'], "Admin Port", "admin_port","dashicons-networking");
	    m8c_variable_entry( $m8c_gd['protocol_version'], "Protocol Version", "protocol_version","dashicons-networking");
	    m8c_variable_entry( $m8c_gd['protocol_compression_algorithms'], "Protocol Compression Algorithms", "protocol_compression_algorithms","dashicons-networking");
	    m8c_variable_entry( $m8c_gd['skip_name_resolve'], "Skip DNS resolving", "skip_name_resolve","dashicons-admin-site-alt3");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
<legend>Misc</legend> 
<table>
	<?php
	    m8c_variable_entry( $m8c_gd_mem, "Total Memory Allocated", false,"dashicons-performance", "calc");
	    m8c_variable_entry( $m8c_gd_uptime, "Uptime", false,"dashicons-clock", "calc");
	    m8c_variable_entry( $m8c_gd_laststartup, "Last Startup", false,"dashicons-update", "calc");
	    m8c_variable_entry( $m8c_gd['time_zone'], "Time Zone", "time_zone","dashicons-admin-site-alt");
	    m8c_variable_entry( $m8c_gd['system_time_zone'], "System Time Zone", "system_time_zone","dashicons-admin-site-alt3");
	    m8c_variable_entry( $m8c_gd['character_set_server'], "Server Character Set", "character_set_server","dashicons-editor-textcolor");
	    m8c_variable_entry( $m8c_gd['collation_server'], "Server Collation", "collation_server","dashicons-editor-spellcheck");
	?>
</table>
</fieldset>

<fieldset class="m8c">
<legend>Logs</legend> 
<table>
	<?php
	m8c_variable_entry( $m8c_gd['log_timestamps'], "Log Timestamp", "log_timestamps","dashicons-calendar-alt");
	m8c_variable_entry( $m8c_gd['log_error'], "Error Log File", "log_error","dashicons-visibility");
	m8c_variable_entry( $m8c_gd['log_error_services'], "Error Log Services", "log_error_services","dashicons-visibility");
	m8c_variable_entry( $m8c_gd['log_error_suppression_list'], "Error Log Suppression List","log_error_suppression_list", "dashicons-filter");
	m8c_variable_entry( $m8c_gd['log_error_verbosity'], "Error Log Verbosity", "log_error_verbosity", "dashicons-filter");
	m8c_variable_entry( $m8c_gd['general_log'], "General Log", "general_log","dashicons-welcome-write-blog");
	m8c_variable_entry( $m8c_gd['general_log_file'], "General Log File", "general_log_file","dashicons-welcome-write-blog");
	m8c_variable_entry( $m8c_gd['performance_schema_max_sql_text_length'], "SQL Text Length in PFS", "performance_schema_max_sql_text_length","dashicons-text-page");
	?>
</table>
</fieldset>
<?php
    if ( $m8c_gd['performance_schema_max_sql_text_length'] < 5000 ) {
	  if ( $dbInformation['isCloud'] ) {
         $my_msg = "SQL Text in Performance Schema might be truncated as the value
		            of performance_schema_max_sql_text_length is 
					only ".$m8c_gd['performance_schema_max_sql_text_length'] .".";
	  } else {
         $my_msg = "It is recommended to have longer SQL Text in Performance Schema:
           <pre>
             SET PERSIST_ONLY performance_schema_max_sql_text_length=5000;</pre>";
	  }
      ?> 
        <div class="notice notice-warning">
        <p><?php _e( $my_msg, 'mysql8-companion' ); ?></p>
        </div>
<?php
	}
?>
<fieldset class="m8c">
<legend>Slow Query Log</legend> 
<table>
	<?php
	m8c_variable_entry( $m8c_gd['slow_query_log'], "Slow Query Log", "slow_query_log","dashicons-clock");
	m8c_variable_entry( $m8c_gd['slow_query_log_file'], "Slow Query Log File", "slow_query_log_file","dashicons-clock");
	m8c_variable_entry( $m8c_gd['long_query_time'], "Long Query Time", "long_query_time","dashicons-admin-settings");
	m8c_variable_entry( $m8c_gd['log_slow_admin_statements'], "Log Admin Statements", "log_slow_admin_statements","dashicons-admin-settings");
	m8c_variable_entry( $m8c_gd['log_slow_replica_statements'], "Log Replication Statements", "log_slow_replica_statements","dashicons-admin-settings");
	m8c_variable_entry( $m8c_gd['log_queries_not_using_indexes'], "Log Queries Not Using Indexes", "log_queries_not_using_indexes","dashicons-admin-settings");
	m8c_variable_entry( $m8c_gd['log_throttle_queries_not_using_indexes'], "Throttle Queries Not Using Indexes", "log_throttle_queries_not_using_indexes","dashicons-admin-settings");
	m8c_variable_entry( $m8c_gd['min_examined_row_limit'], "Minimum Examined Rows", "min_examined_row_limit","dashicons-admin-settings");
	?>
</table>
</fieldset>
