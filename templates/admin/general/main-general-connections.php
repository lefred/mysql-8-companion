<?php
   $m8c_ConnData = new M8C\ConnectionData();
   $m8c_cd = $m8c_ConnData->get();
   $m8c_ccd = $m8c_ConnData->getConnControl();
   $m8c_cm = $m8c_ConnData->getConnMemory();
?>
<div class="m8c-grid">
<fieldset class="m8c">
  <legend>WP Connection</legend> 
  <table>
	<?php
	    m8c_variable_entry( $m8c_cd['connection_id'], "Connection ID", "connection_id","dashicons-info-outline", "tls");
	    m8c_variable_entry( $m8c_cd['connection_type'], "Connection Type", "connection_type","dashicons-admin-links", "tls");
	    m8c_variable_entry( $m8c_cd['name'], "Connection Name", "name","dashicons-nametag", "tls");
	    m8c_variable_entry( $m8c_cd['tls_version'], "TLS Version", "tls_version","dashicons-lock", "tls");
	    m8c_variable_entry( $m8c_cd['cipher'], "Cipher", "cipher","dashicons-admin-network", "tls");
	    m8c_variable_entry( $m8c_cd['user'], "User", "user","dashicons-admin-users", "tls");
	    m8c_variable_entry( $m8c_cd['host'], "Host", "host","dashicons-laptop", "tls");
	?>
  </table>
</fieldset>


<fieldset class="m8c">
  <legend>Connection Settings</legend> 
  <table>
	<?php
	    m8c_variable_entry( $m8c_gd['character_set_connection'], "Character Set", "character_set_connection","dashicons-editor-textcolor");
	    m8c_variable_entry( $m8c_gd['collation_connection'], "Collation", "collation_connection","dashicons-editor-spellcheck");
	    m8c_variable_entry( $m8c_gd['max_connect_errors'], "Max Connect Errors", "max_connect_errors","dashicons-dismiss");
	    m8c_variable_entry( $m8c_gd['max_connections'], "Max Connections", "max_connections","dashicons-arrow-up-alt");
	    m8c_variable_entry( $m8c_gd['max_user_connections'], "Max User Connections", "max_user_connections","dashicons-groups");
	    m8c_variable_entry( $m8c_gd['wait_timeout'], "Wait Timeout", "wait_timeout","dashicons-clock");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>Connection Control</legend> 
  <table>
	<?php
	    $m8c_cc = false;
	    foreach ($m8c_ccd as $row) {
	    	m8c_variable_entry( $row['plugin_status'], $row['plugin_name'], $row['plugin_status'] ,"dashicons-admin-plugins", "tls");
	    	$m8c_cc = true;
		}
	    m8c_variable_entry( $m8c_gd['connection_control_failed_connections_threshold'], "Failed Connection Treshold", "connection_control_failed_connections_threshold","dashicons-clock");
	    m8c_variable_entry( $m8c_gd['connection_control_min_connection_delay'], "Minimum Delay To Add", "connection_control_min_connection_delay","dashicons-minus");
	    m8c_variable_entry( $m8c_gd['connection_control_max_connection_delay'], "Maximum Delay To Add", "connection_control_max_connection_delay","dashicons-plus");
	    if ($m8c_cc == false) {
			echo ('<tr><td><a href="https://dev.mysql.com/doc/refman/8.0/en/connection-control-installation.html"><small><span class="dashicons dashicons-info"></span></small></a>');
			printf(__("No connection control plugin enabled."));
			echo ('</td></tr>');
		}
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>Connection Memory Tracking</legend> 
  <table>
	<?php
	    m8c_variable_entry( $m8c_gd['global_connection_memory_tracking'], "Connection Memory Tracking", "global_connection_memory_tracking","dashicons-chart-line");
	    m8c_variable_entry( m8c_format_bytes($m8c_gd['global_connection_memory_limit']), "Global Connection Memory Limit", "global_connection_memory_limit","dashicons-dismiss");
	    m8c_variable_entry( m8c_format_bytes($m8c_gd['connection_memory_limit']), "Connection Memory Limit", "connection_memory_limit","dashicons-dismiss");
	    m8c_variable_entry( m8c_format_bytes($m8c_cd['Global_connection_memory']), "Global Connection Memory Usage", "global_connection_memory","dashicons-chart-area","memory");
	?>
  </table>
</fieldset>
</div>
<fieldset class="m8c-error">
  <legend>Connections Memory Usage</legend> 
    <table class="m8c-logs-2">
		<tr><th>Processlit ID</th>
		<th>Controlled Memory</th>
		<th>Max Controlled Memory</th>
		<th>Total Memory</th>
		<th>Max Total Memory</th></tr>
	<?php
	    foreach ($m8c_cm as $row) {
       		echo("<tr><td>".$row['processlist_id']."</td><td>"); 
       		echo($row['controlled_memory']."</td><td>"); 
       		echo($row['max_controlled_memory']."</td><td>"); 
       		echo($row['total_memory']."</td><td>"); 
       		echo($row['max_total_memory']."</td></tr>"); 
    	}
	?>
  </table>
</fieldset>