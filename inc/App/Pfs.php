<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.1
 */

namespace M8C;

class Pfs {

    public function __construct() {

    }
    
    public static function getSumm() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT object_schema,          
                  CONCAT(ROUND((SUM(count_read)/SUM(count_star))*100, 2),'%') `reads`,
                  CONCAT(ROUND((SUM(count_write)/SUM(count_star))*100, 2),'%') `writes`
                  FROM performance_schema.table_io_waits_summary_by_table
                  WHERE count_star > 0 and object_schema = database()
                  GROUP BY object_schema;";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $pfs_summ[$variable] = wp_kses( $value, 'strip' );
        }

        $query = "SELECT table_schema, format(sum(table_rows),0) 'ROWS', 
                         FORMAT_BYTES(sum(data_length)) DATA, 
                         FORMAT_BYTES(sum(index_length)) IDX, 
                         FORMAT_BYTES( sum(data_length) + sum(index_length)) 'TOTAL_SIZE', 
                         FORMAT_BYTES(sum(FILE_SIZE)) FILE_SIZE,
                         FORMAT_BYTES((sum(FILE_SIZE)/10 - (sum(data_length)/10 +
                               sum(index_length)/10))*10) WASTED_SIZE,
                         ROUND(sum(index_length) / sum(data_length), 2) IDXFRAC 
                         FROM information_schema.TABLES as t
                         JOIN information_schema.INNODB_TABLESPACES as it
                           ON it.name = concat(table_schema,'/',table_name)
                         WHERE table_schema =database() 
                         GROUP BY table_schema order by  sum(data_length) + sum(index_length) desc;
                  ";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $pfs_summ[$variable] = wp_kses( $value, 'strip' );
        }

        return $pfs_summ;
    }


    public static function getTablesOptimize() {
        $pfs_optimize = array();
        global $wpdb;

        $query = "SELECT TABLE_NAME, TABLE_ROWS, format_bytes(data_length) DATA_SIZE,
                  format_bytes(index_length) INDEX_SIZE,
                  format_bytes(data_length+index_length) TOTAL_SIZE,
                  format_bytes(data_free) DATA_FREE,
                  format_bytes(FILE_SIZE) FILE_SIZE,
                  format_bytes((FILE_SIZE/10 - (data_length/10 + 
                     index_length/10))*10) WASTED_SIZE,
                  ((FILE_SIZE/10 - (data_length/10 + 
                     index_length/10))*10) WASTED_SIZE_RAW    
                  FROM information_schema.TABLES as t   
                  JOIN information_schema.INNODB_TABLESPACES as it   
                    ON it.name = concat(table_schema,'/',table_name)
                 WHERE table_schema =database() 
                 ORDER BY (data_length + index_length) desc LIMIT 10;";

        $variables = $wpdb->get_results($query);
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_optimize[]=$line;
        }
        return $pfs_optimize;
    }

    public static function getTopRW() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT object_name,         
                  CONCAT(ROUND((count_read/count_star)*100, 2),'%') `reads`,
                  CONCAT(ROUND((count_write/count_star)*100, 2),'%') `writes`
                  FROM performance_schema.table_io_waits_summary_by_table
                  WHERE count_star > 0 and object_schema=database()
                  ORDER BY count_star DESC limit 10;";

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

    public static function getTopSize() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT table_name, format(sum(table_rows),0) 'ROWS', 
                         FORMAT_BYTES(sum(data_length)) DATA, 
                         FORMAT_BYTES(sum(index_length)) IDX, 
                         FORMAT_BYTES( sum(data_length) + sum(index_length)) 'TOTAL SIZE', 
                         ROUND(sum(index_length) / sum(data_length), 2) IDXFRAC 
                         FROM information_schema.TABLES 
                         where table_schema =database() 
                         GROUP BY table_schema, table_name 
                         order by  sum(data_length) + sum(index_length) 
                         desc limit 10;";

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


    public static function getNoPK() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT i.TABLE_ID, TABLE_NAME  
                   FROM INFORMATION_SCHEMA.INNODB_INDEXES i  
                   JOIN INFORMATION_SCHEMA.INNODB_TABLES t 
                     ON (i.TABLE_ID = t.TABLE_ID)  
                   JOIN INFORMATION_SCHEMA.TABLES it 
                     ON concat(it.table_schema,'/',it.table_name)=t.name 
                  WHERE i.NAME='GEN_CLUST_INDEX' and table_schema=database();";

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

    public static function getDupIdx() {
        $pfs_summ = array();
        $error = false;
        global $wpdb;

        $query = "select t2.table_name, t2.redundant_index_name, t2.redundant_index_columns,
                         t2.dominant_index_name, t2.dominant_index_columns, 
                         format_bytes(stat_value * @@innodb_page_size) size    
                  from mysql.innodb_index_stats t1    
                  join sys.schema_redundant_indexes t2 
                    on table_schema=database_name and t2.table_name=t1.table_name    
                   and t2.redundant_index_name=t1.index_name   
                 where stat_name='size' and table_schema=database() order by stat_value desc;";

        $variables = $wpdb->get_results($query);
        if($wpdb->last_error != '') {
            if (str_contains($wpdb->last_error, "command denied")) {
              $error = true; 
            }
        }
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_summ[]=$line;
        }

        $return_arr = array();
        $return_arr[]=$pfs_summ;
        $return_arr[]=$error;

        return $return_arr;
    }  
    
    public static function getNotUsedIdx() {
        $pfs_summ = array();
        $error = false;
        global $wpdb;

        $query = "select table_name, t1.index_name,         
                         format_bytes(stat_value * @@innodb_page_size) size 
                  from mysql.innodb_index_stats t1       
                  join sys.schema_unused_indexes t2 on object_schema=database_name 
                   and object_name=table_name and t2.index_name=t1.index_name     
                  where stat_name='size' and database_name=database() 
                  order by stat_value desc;";

        $variables = $wpdb->get_results($query);
        if($wpdb->last_error != '') {
            if (str_contains($wpdb->last_error, "command denied")) {
              $error = true; 
            }
        }
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_summ[]=$line;
        }

        $return_arr = array();
        $return_arr[]=$pfs_summ;
        $return_arr[]=$error;

        return $return_arr;
    }   
    
    public static function getTopQueries() {
        $pfs_summ = array();
        global $wpdb;

        $query = "SELECT format_pico_time(total_latency) tot_lat,           
                         exec_count, format_pico_time(total_latency/exec_count) latency_per_call,
                         query_sample_text    
                    FROM sys.x$statements_with_runtimes_in_95th_percentile AS t1   
                    JOIN performance_schema.events_statements_summary_by_digest AS t2      
                      ON t2.digest=t1.digest   
                   WHERE schema_name = database()  
                   ORDER BY (total_latency) desc LIMIT 1";

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
    
    public static function getBadDefault() {
        $pfs_baddef = array();
        global $wpdb;

        $query = "select table_name, column_name, data_type, 
                         column_default 
                  from information_schema.columns where table_schema=database() 
                   and column_default like '0000-00-00%';
        ";

        $variables = $wpdb->get_results($query);
        foreach( $variables as $row ) {
            $line = array();
            foreach ( $row as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $pfs_baddef[]=$line;
        }

        return $pfs_baddef;
    }  

}