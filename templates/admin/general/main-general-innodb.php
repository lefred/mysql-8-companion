<?php
   $m8c_InnoDB = new M8C\InnoDB();
   $m8c_innodb = $m8c_InnoDB->getBP();
   $m8c_ahi = $m8c_InnoDB->getAHI();
?>
<div class="m8c-grid">
<fieldset class="m8c">
  <legend>InnoDB</legend> 
  <table>
	<?php
    m8c_variable_entry( $m8c_gd['innodb_version'], "InnoDB Version", "innodb_version","dashicons-media-code");
    m8c_variable_entry( $m8c_ahi['RedoEnabled'], "Redo Log Enabled", "redo_log","dashicons-image-rotate", "redo");
    m8c_variable_entry( m8c_format_bytes($m8c_gd['innodb_redo_log_capacity']), "Redo Log Capacity", "innodb_redo_log_capacity","dashicons-block-default");
    m8c_variable_entry( $m8c_gd['innodb_undo_tablespaces'], "Undo Tablespaces", "innodb_undo_tablespaces","dashicons-screenoptions");
    m8c_variable_entry( round($m8c_gd['innodb_max_dirty_pages_pct'],2)."%", "Max Dirty Page", "innodb_max_dirty_pages_pct","dashicons-forms");
	?>
	</table>
</fieldset>

<fieldset class="m8c">
  <legend>InnoDB Buffer Pool</legend> 
  <table>
	<?php
    m8c_variable_entry( m8c_format_bytes($m8c_gd['innodb_buffer_pool_size']), "Buffer Pool Size", "innodb_buffer_pool_size","dashicons-block-default");
    m8c_variable_entry( $m8c_gd['innodb_buffer_pool_instances'], "Buffer Pool Instance(s)", "innodb_buffer_pool_instances","dashicons-screenoptions");
    m8c_variable_entry( $m8c_innodb['BufferPoolFullPct']."%", "Buffer Pool Usage", "buffer_pool_usage","dashicons-screenoptions", "bp");
    m8c_variable_entry( $m8c_innodb['BufferPoolDirtyPct']."%", "Buffer Pool Dirty", "buffer_pool_usage","dashicons-forms", "bp");
    m8c_variable_entry( $m8c_innodb['DiskReadRatio'], "Disk Read Ratio", "disk_read_ratio","dashicons-chart-pie", "bp");
	?>
	</table>
</fieldset>

<fieldset class="m8c">
  <legend>InnoDB AHI</legend> 
  <table>
	<?php
    m8c_variable_entry( $m8c_ahi['AHIEnabled'], "Adaptive Hash Index", "innodb_adaptive_hash_index","dashicons-media-spreadsheet","innodb");
    m8c_variable_entry( $m8c_ahi['AHIParts'], "Adaptive Hash Index Parts", "innodb_adaptive_hash_index","dashicons-image-filter","innodb");
    m8c_variable_entry( $m8c_ahi['AHIRatio']."%", "Adaptive Hash Index Ratio", "innodb_adaptive_hash_index","dashicons-star-half","innodb");
	?>
	</table>
</fieldset>

<fieldset class="m8c">
  <legend>InnoDB & System</legend> 
  <table>
	<?php
    if ( $m8c_ahi['CPU'] == 0 ) {
      $my_msg = "InnoDB Metrics for <strong>cpu_n</strong> are disabled. Please enable them
      check if WordPress DB user has the PROCESS privilege:
        <pre>
        SET GLOBAL innodb_monitor_enable = 'cpu_n';
        GRANT PROCESS ON *.* TO ". DB_USER .";</pre>";
      ?> 
        <div class="notice notice-warning">
        <p><?php _e( $my_msg, 'mysql8-companion' ); ?></p>
        </div>
      <?php
      m8c_variable_entry( "N/A", "CPU Cores", "cpu","dashicons-info", "cpu");
    } else {
      m8c_variable_entry( $m8c_ahi['CPU'], "CPU Cores", "cpu","dashicons-info", "cpu");
    }
    m8c_variable_entry( $m8c_gd['innodb_numa_interleave'], "NUMA Interleave", "innodb_numa_interleave","dashicons-grid-view", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_io_capacity'], "I/O Capacity", "innodb_io_capacity","dashicons-image-flip-vertical", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_io_capacity_max'], "I/O Capacity Max", "innodb_io_capacity","dashicons-image-flip-vertical", "innodb");
	?>
	</table>
</fieldset>

<fieldset class="m8c">
  <legend>InnoDB Threads</legend> 
  <table>
	<?php
    m8c_variable_entry( $m8c_gd['innodb_read_io_threads'], "InnoDB Read I/O Threads", "innodb_read_io_threads","dashicons-database-export", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_write_io_threads'], "InnoDB Write I/O Threads", "innodb_write_io_threads","dashicons-database-import", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_log_writer_threads'], "InnoDB Dedicated Log Writer Threads", "innodb_log_writer_threads","dashicons-edit-page", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_purge_threads'], "InnoDB Purge Threads", "innodb_purge_threads","dashicons-trash", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_parallel_read_threads'], "InnoDB Read Parallel Threads", "innodb_parallel_read_threads","dashicons-admin-page", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_ddl_threads'], "InnoDB DDL Threads", "innodb_ddl_threads","dashicons-editor-contract", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_page_cleaners'], "InnoDB Dirty Page Cleaner Threads", "innodb_page_cleaners","dashicons-admin-appearance", "innodb");
	?>
	</table>
</fieldset>

<fieldset class="m8c">
  <legend>InnoDB Durability</legend> 
  <table>
	<?php
    m8c_variable_entry( $m8c_gd['innodb_flush_method'], "InnoDB Flush Method", "innodb_flush_method","dashicons-info", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_flush_log_at_trx_commit'], "Flush Log at Trx Commit", "innodb_flush_log_at_trx_commit","dashicons-database-import", "innodb");
    m8c_variable_entry( $m8c_gd['sync_binlog'], "Sync Binlog", "sync_binlog","dashicons-database-import");
    m8c_variable_entry( $m8c_gd['innodb_doublewrite'], "Double Write Buffer", "innodb_doublewrite","dashicons-admin-page", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_doublewrite_files'], "Double Write Files", "innodb_doublewrite_files","dashicons-screenoptions", "innodb");
    m8c_variable_entry( $m8c_gd['innodb_use_fdatasync'], "Use fdatasync()", "innodb_use_fdatasync","dashicons-download", "innodb");
	?>
	</table>
</fieldset>


<?php  
  
	unset( $m8c_gd_innodb );