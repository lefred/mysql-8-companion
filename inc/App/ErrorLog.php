<?php
/**
 * @package MySQL8 Companion
 * @version 0.0.1
 */

namespace M8C;

class ErrorLog {

    public function __construct() {

    }
    
    public static function get($logged="",$dir="desc",$limit=100,$offset=0,$prio="",$subsystem="") {
        $errordata = array();
        global $wpdb;
        $where_str="";
        if (strlen($logged) > 0)  {
            $where_str .= "logged >= '$logged'";
            $dir = "";
        }

        if (strlen($prio) > 0) {
            if (strlen($where_str) > 0) $where_str .= " and prio='$prio'";
            else $where_str .= "prio='$prio'";
        }
        if (strlen($subsystem) > 0) {
            if (strlen($where_str) > 0) $where_str .= " and subsystem='$subsystem'";
            else $where_str .= "subsystem='$subsystem'";
        }

        if (strlen($where_str) > 0)  $where_str = "WHERE " . $where_str; 
        $query = "select * from (
            select * from performance_schema.error_log $where_str 
            order by logged $dir limit $offset, $limit
            ) a order by logged"; 
        //echo $query;
        $logs = $wpdb->get_results($query);
        foreach ($logs as $rows) {
            $line=array();
            foreach( $rows as $variable => $value ) {
               $line[$variable] = wp_kses( $value, 'strip' );
            }
            $errordata[]=$line;
        }

        return $errordata;
    }
}