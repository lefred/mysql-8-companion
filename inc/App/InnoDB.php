<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.2
 */

namespace M8C;

class InnoDB {

    public function __construct() {

    }
    
    public static function getBP() {
        $innodbdata = array();
        global $wpdb;

        $query = "SELECT format_bytes(@@innodb_buffer_pool_size) BufferPoolSize,
                            FORMAT(A.num * 100.0 / B.num,2) BufferPoolFullPct, 
                            FORMAT(C.num * 100.0 / D.num,2) BufferPoolDirtyPct
                    FROM
                        (SELECT variable_value num FROM performance_schema.global_status
                        WHERE variable_name = 'Innodb_buffer_pool_pages_data') A,
                        (SELECT variable_value num FROM performance_schema.global_status
                        WHERE variable_name = 'Innodb_buffer_pool_pages_total') B,
                        (SELECT variable_value num FROM performance_schema.global_status 
                        WHERE variable_name='Innodb_buffer_pool_pages_dirty') C, 
                        (SELECT variable_value num FROM performance_schema.global_status 
                        WHERE variable_name='Innodb_buffer_pool_pages_total') D;"; 

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $innodbdata[$variable] = wp_kses( $value, 'strip' );
        }

        $query = "SELECT CONCAT(FORMAT(B.num * 100.0 / A.num,2),'%') DiskReadRatio
                    FROM (
                    SELECT variable_value num FROM performance_schema.global_status 
                    WHERE variable_name = 'Innodb_buffer_pool_read_requests') A, 
                    (SELECT variable_value num FROM performance_schema.global_status 
                        WHERE variable_name = 'Innodb_buffer_pool_reads') B;";
        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $innodbdata[$variable] = wp_kses( $value, 'strip' );
        }
                         
        return $innodbdata;
    }

    public static function getAHI() {
        $innodbdata = array();
        global $wpdb;

        $query = "SELECT ROUND(
            (
              SELECT Variable_value FROM sys.metrics
              WHERE Variable_name = 'adaptive_hash_searches'
            ) /
            (
              (
               SELECT Variable_value FROM sys.metrics
               WHERE Variable_name = 'adaptive_hash_searches_btree'
              )  + (
               SELECT Variable_value FROM sys.metrics
               WHERE Variable_name = 'adaptive_hash_searches'
              )
            ) * 100,2
          ) 'AHIRatio',
		  (
					SELECT variable_value
					FROM performance_schema.global_variables
					WHERE variable_name = 'innodb_adaptive_hash_index'
		  ) AHIEnabled,
		  (
					SELECT variable_value
					FROM performance_schema.global_variables
					WHERE variable_name = 'innodb_adaptive_hash_index_parts'
		  ) AHIParts,
          (
                    SELECT VARIABLE_VALUE 
                    FROM performance_schema.global_status 
                    WHERE VARIABLE_NAME = 'Innodb_redo_log_enabled'
          ) RedoEnabled,
          (
            select count from information_schema.INNODB_METRICS 
            where name = 'cpu_n'
           ) CPU;";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $innodbdata[$variable] = wp_kses( $value, 'strip' );
        }
        
        return $innodbdata;
    }
}
