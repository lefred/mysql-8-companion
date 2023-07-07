<?php
/**
 * @package MySQL8 Companion
 * @version 1.0.1
 */

namespace M8C;

class GeneralData {

    public function __construct() {

    }
    
    public static function getMemAll() {
       $total_mem = "n/a";
       global $wpdb;

       $query = "select * from sys.memory_global_total;";
       $res = $wpdb->get_results($query, ARRAY_A);
       if ($res) {
        $total_mem = $res[0]['total_allocated'];
       }

       return $total_mem;
    }

    public static function getUptime() {
       $uptime = "n/a";
       global $wpdb;

       $query = "select variable_value uptime 
                 from performance_schema.global_status where variable_name='uptime';";
       $res = $wpdb->get_results($query, ARRAY_A);
       if ($res) {
        $uptime_sec = $res[0]['uptime'];
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$uptime_sec");
        $uptime = $dtF->diff($dtT)->format('%ad %hh %im %ss');
       }

       return $uptime;
    }

    public static function getLastStartup() {
        $last_startup = "n/a";
        global $wpdb;
 
        $query = "select date_format(DATE_SUB(now(), INTERVAL variable_value SECOND),
                  '%a %Y-%m-%d %H:%i:%s') last_start 
                  from performance_schema.global_status where variable_name='Uptime';";
        $res = $wpdb->get_results($query, ARRAY_A);
        if ($res) {
         $last_startup = $res[0]['last_start'];
        }
 
        return $last_startup;
    }

    public static function get() {

        $generaldata = array();
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $variablelist = array(
            'admin_address',
            'admin_port',
            'autocommit',
            'bind_address',
            'character_set_client',
            'character_set_connection',
            'character_set_database',
            'character_set_filesystem',
            'character_set_results',
            'character_set_server',
            'character_set_system',
            'collation_connection',
            'collation_database',
            'collation_server',
            'concurrent_insert',
            'connect_timeout',
            'connection_control_failed_connections_threshold',
            'connection_control_min_connection_delay',
            'connection_control_max_connection_delay',
            'date_format',
            'datetime_format',
            'error_count',
            'expire_logs_days',
            'general_log',
            'general_log_file',
            'global_connection_memory_tracking',
            'global_connection_memory_limit',
            'connection_memory_limit',
            'have_compress',
            'have_crypt',
            'have_dynamic_loading',
            'have_geometry',
            'have_openssl',
            'have_profiling',
            'have_query_cache',
            'have_rtree_keys',
            'have_ssl',
            'have_symlink',
            'histogram_size',
            'histogram_type',
            'hostname',
            'innodb_version',
            'innodb_flush_method',
            'innodb_flush_log_at_trx_commit',
            'innodb_doublewrite',
            'innodb_doublewrite_files',
            'innodb_io_capacity',
            'innodb_io_capacity_max',
            'innodb_numa_interleave',
            'innodb_ddl_threads',
            'innodb_parallel_read_threads',
            'innodb_adaptive_hash_index',
            'innodb_buffer_pool_size',
            'innodb_buffer_pool_instances',
            'innodb_max_dirty_pages_pct',
            'innodb_log_writer_threads',
            'innodb_page_cleaners',
            'innodb_purge_threads',
            'innodb_read_io_threads',
            'innodb_redo_log_capacity',
            'innodb_undo_tablespaces',
            'innodb_use_fdatasync',
            'innodb_use_native_aio',
            'innodb_write_io_threads',
            'lc_messages',
            'lc_time_names',
            'license',
            'long_query_time',
            'log_slow_admin_statements',
            'log_queries_not_using_indexes',
            'log_throttle_queries_not_using_indexes',
            'min_examined_row_limit',
            'log_slow_replica_statements',
            'max_connections',
            'max_connect_errors',
            'max_user_connections',
            'max_error_count',
            'performance_schema_max_sql_text_length',
            'port',
            'protocol_version',
            'protocol_compression_algorithms',
            'read_only',
            'require_secure_transport',
            'server_id',
            'log_error',
            'log_error_services',
            'log_error_suppression_list',
            'log_error_verbosity',
            'log_timestamps',
            'show_gipk_in_create_table_and_information_schema',
            'skip_name_resolve',
            'slow_query_log',
            'slow_query_log_file',
            'sql_generate_invisible_primary_key',
            'sql_mode',
            'storage_engine',
            'sync_binlog',
            'system_time_zone',
            'time_format',
            'time_zone',
            'timestamp',
            'tls_version',
            'version',
            'version_comment',
            'version_compile_machine',
            'version_compile_os',
            'version_malloc_library',
            'version_source_revision',
            'version_ssl_library',
            'wait_timeout',
            'warning_count',
        );


        $variables = $wpdb->get_results( "SHOW variables" );

        foreach( $variables as $variable ) {

            if( in_array( $variable->Variable_name, $variablelist ) ) {
                if( isset( $variable->Value ) ) {
                    $generaldata[$variable->Variable_name] = wp_kses( $variable->Value, 'strip' );
                }
            }

        }
        return $generaldata;

    }

}
