<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.1
 */

namespace M8C;

class Pfs2 {

    public function __construct() {

    }

    public static function getExpensive() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT format_pico_time(total_latency) tot_lat,
                         exec_count, 
                         format_pico_time(total_latency/exec_count) latency_per_call,         
                         query,
                         query_sample_text,    
                         date_format(t1.first_seen,'%Y-%m-%d %H:%i:%s') first_seen, 
                         date_format(t1.last_seen,'%Y-%m-%d %H:%i:%s') last_seen,
                         t1.digest   
                  FROM sys.x\$statements_with_runtimes_in_95th_percentile AS t1   
                  JOIN performance_schema.events_statements_summary_by_digest AS t2      
                    ON t2.digest=t1.digest   
                 WHERE schema_name = database()
                   AND  query not like '%performance_schema` .%' 
                   AND  query not like '%information_schema` .%' 
                   AND  query not like '%mysql` .%' 
                   AND  query not like '%sys` .%' 
                   AND  query not like 'EXPLAIN%'  
                  ORDER BY (total_latency) desc LIMIT 10;";

        $variables = $wpdb->get_results($query);
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_summ[]=$line;
        }

        return $pfs_summ;
    }


    public static function getSlowest() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT format_pico_time(total_latency) tot_lat,
                         exec_count, 
                         format_pico_time(total_latency/exec_count) latency_per_call,         
                         query,
                         query_sample_text,
                         date_format(t1.first_seen,'%Y-%m-%d %H:%i:%s') first_seen, 
                         date_format(t1.last_seen,'%Y-%m-%d %H:%i:%s') last_seen,
                         t1.digest    
                  FROM sys.x\$statements_with_runtimes_in_95th_percentile AS t1   
                  JOIN performance_schema.events_statements_summary_by_digest AS t2      
                    ON t2.digest=t1.digest   
                 WHERE schema_name = database() 
                   AND  query not like '%performance_schema` .%' 
                   AND  query not like '%information_schema` .%' 
                   AND  query not like '%mysql` .%' 
                   AND  query not like '%sys` .%' 
                   AND  query not like 'EXPLAIN%' 
                 ORDER BY (total_latency/exec_count) desc LIMIT 10;";

        $variables = $wpdb->get_results($query);
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_summ[]=$line;
        }

        return $pfs_summ;
    }   
    
    public static function getFullScan() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT format_pico_time(total_latency) tot_lat,
                         exec_count, 
                         format_pico_time(total_latency/exec_count) latency_per_call,         
                         query,
                         query_sample_text,
                         date_format(t1.first_seen,'%Y-%m-%d %H:%i:%s') first_seen, 
                         date_format(t1.last_seen,'%Y-%m-%d %H:%i:%s') last_seen,
                         t1.digest    
                  FROM sys.x\$statements_with_full_table_scans AS t1   
                  JOIN performance_schema.events_statements_summary_by_digest AS t2      
                    ON t2.digest=t1.digest   
                 WHERE schema_name = database() 
                   AND  query not like '%performance_schema` .%' 
                   AND  query not like '%information_schema` .%' 
                   AND  query not like '%mysql` .%' 
                   AND  query not like '%sys` .%' 
                   AND  query not like 'EXPLAIN%' 
                 ORDER BY total_latency desc LIMIT 10;";

        $variables = $wpdb->get_results($query);
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_summ[]=$line;
        }

        return $pfs_summ;
    }     
}    