<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.1
 */

namespace M8C;

class ConnectionData {

    public function __construct() {

    }
    
    public static function get() {
        $conndata = array();
        global $wpdb;

        $query = "select t3.variable_value Global_connection_memory, 
                    connection_id() connection_id, connection_type, 
                    substring_index(substring_index(name,'/',2),'/',-1) name,
                    sbt.variable_value AS tls_version, t2.variable_value AS cipher,
                    processlist_user AS user, processlist_host AS host
                  from performance_schema.status_by_thread AS sbt
                  join performance_schema.threads AS t
                    on t.thread_id = sbt.thread_id
                  join performance_schema.status_by_thread AS t2
                    on t2.thread_id = t.thread_id
                  join performance_schema.global_status t3 
                  where processlist_id=connection_id()
                    and sbt.variable_name = 'Ssl_version' 
                    and t2.variable_name = 'Ssl_cipher' 
                    and t3.variable_name='Global_connection_memory'
                  order by connection_type, tls_version;";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $conndata[$variable] = wp_kses( $value, 'strip' );
        }

        return $conndata;
    }

    public static function getConnControl() {
      $conncontroldata = array();
      global $wpdb;

      $query = "select plugin_name, plugin_status from information_schema.plugins
                where plugin_name like 'connection%';";

      $variables = $wpdb->get_results($query);
      foreach ($variables as $rows) {
        $line=array();
        foreach( $rows as $variable => $value ) {
           $line[$variable] = wp_kses( $value, 'strip' );
        }
        $conncontroldata[]=$line;
      }

      return $conncontroldata;
      
    }

    public static function getConnMemory() {
      $conndata = array();
      global $wpdb;

        $query = "select t1.processlist_id,
                         FORMAT_BYTES(t1.CONTROLLED_MEMORY) controlled_memory, 
                         FORMAT_BYTES(t1.MAX_CONTROLLED_MEMORY) max_controlled_memory, 
                         FORMAT_BYTES(t1.TOTAL_MEMORY) total_memory, 
                         FORMAT_BYTES(t1.MAX_TOTAL_MEMORY) max_total_memory 
                     from performance_schema.threads t1
                     join performance_schema.threads t2 using(processlist_user)
                       where t2.PROCESSLIST_ID=CONNECTION_ID()
                         and t1.processlist_id is not NULL;";
      $variables = $wpdb->get_results($query);
      foreach ($variables as $rows) {
        $line=array();
        foreach( $rows as $variable => $value ) {
           $line[$variable] = wp_kses( $value, 'strip' );
        }
        $conndata[]=$line;
      }
      return $conndata;

    }

}