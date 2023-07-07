<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.1
 */

namespace M8C;

class HeatWave {

    public function __construct() {

    }
    
    public static function getHeatWaveInfo() {
        $heatwave_info = array();
        global $wpdb;

        $query = "select variable_name, variable_value 
                    from performance_schema.session_variables 
                   where variable_name = 'secondary_engine_cost_threshold';";
        $variables = $wpdb->get_results($query);
        foreach ($variables as $rows) {
            $line=array();
            foreach( $rows as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $heatwave_info[$line['variable_name']]=$line['variable_value'];
        } 

        $query = "select variable_name, variable_value 
                    from performance_schema.global_status
                   where variable_name like 'rapid_%' 
                      or variable_name like 'hw_%';
                  ";
        $variables = $wpdb->get_results($query);
        foreach ($variables as $rows) {
            $line=array();
            foreach( $rows as $variable => $value ) {
                $line[$variable] = wp_kses( $value, 'strip' );
            }
            $heatwave_info[$line['variable_name']]=$line['variable_value'];
        } 

        return $heatwave_info;
    }

    public static function getHealthMemory() {
        $health_mem = array();
        global $wpdb;

        $query = "select timestamp, process_name, pid, 
                         format_bytes(VM_RSS) vm_rss, 
                         format_bytes(VM_DATA) vm_data, 
                         page_faults 
                  from performance_schema.health_process_memory 
                  order by timestamp desc limit 1;";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $health_mem[$variable] = wp_kses( $value, 'strip' );
        }

        return $health_mem;
    }

    public static function getHealthSystemMemory() {
        $health_sys_mem = array();
        global $wpdb;

        $query = "select format_bytes(total_memory) total_memory, 
                         format_bytes(available) available, 
                         use_percent, 
                         format_bytes(memory_free) memory_free, 
                         memory_fs_cache, 
                         format_bytes(swap_total) swap_total, 
                         format_bytes(swap_free) swap_free
                  from performance_schema.health_system_memory 
                  order by timestamp desc limit 1;";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $health_sys_mem[$variable] = wp_kses( $value, 'strip' );
        }

        return $health_sys_mem;
    }

    public static function getHealthBlockDevice() {
        $health_disk = array();
        global $wpdb;

        $query = "select device, 
                         format_bytes(total_bytes) total_bytes, 
                         format_bytes(available_bytes) available_bytes, 
                         use_percent, 
                         mount_point 
                  from performance_schema.health_block_device 
                  order by timestamp desc limit 1;";

        $variables = $wpdb->get_results($query);
        foreach( $variables[0] as $variable => $value ) {
            $health_disk[$variable] = wp_kses( $value, 'strip' );
        }

        return $health_disk;
    }
}