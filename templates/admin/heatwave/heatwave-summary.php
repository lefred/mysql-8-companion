<?php
   $m8c_heatwave = new M8C\HeatWave();
   $m8c_heatwave_info = $m8c_heatwave->getHeatWaveInfo();
   $m8c_heatwave_mem = $m8c_heatwave->getHealthMemory();
   $m8c_heatwave_sys_mem = $m8c_heatwave->getHealthSystemMemory();
   $m8c_heatwave_disk = $m8c_heatwave->getHealthBlockDevice();
?>
<div class="m8c-grid">
<fieldset class="m8c">
  <legend>HeatWave Cluster</legend> 
  <table width="100%">
	<?php
    m8c_variable_entry( $m8c_heatwave_info['secondary_engine_cost_threshold'], "Offload Threshold", "secondary_engine_cost_threshold","dashicons-image-rotate-right");
    m8c_variable_entry( $m8c_heatwave_info['rapid_service_status'], "Service Status", "rapid_service_status","dashicons-cloud-saved","hw");
    m8c_variable_entry( $m8c_heatwave_info['rapid_cluster_status'], "Cluster Status", "rapid_cluster_status","dashicons-networking","hw");
    m8c_variable_entry( $m8c_heatwave_info['rapid_resize_status'], "Resize Status", "rapid_resize_status","dashicons-image-crop","hw");
    m8c_variable_entry( $m8c_heatwave_info['rapid_query_offload_count'], "Offloaded Queries", "rapid_query_offload_count","dashicons-cloud-upload","hw");
    m8c_variable_entry( $m8c_heatwave_info['hw_data_scanned'], "Data Scanned", "hw_data_scanned","dashicons-code-standards","hw");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>Health Checker Process Memory</legend> 
  <table width="100%">
	<?php
    m8c_variable_entry( $m8c_heatwave_mem['timestamp'], "Timestamp", "timestamp","dashicons-clock","hc");
    m8c_variable_entry( $m8c_heatwave_mem['process_name'], "Process Name", "process_name","dashicons-admin-generic","hc");
    m8c_variable_entry( $m8c_heatwave_mem['pid'], "PID", "pid","dashicons-universal-access","hc");
    m8c_variable_entry( $m8c_heatwave_mem['vm_rss'], "Current Usage (VmRSS)", "vmrss","dashicons-tickets-alt","hc");
    m8c_variable_entry( $m8c_heatwave_mem['vm_data'], "VmData", "vmdata","dashicons-tickets-alt","hc");
    m8c_variable_entry( $m8c_heatwave_mem['page_faults'], "Page Faults", "page_faults","dashicons-warning","hc");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>Health Checker System Memory</legend> 
  <table width="100%">
	<?php
    m8c_variable_entry( $m8c_heatwave_sys_mem['total_memory'], "Total Memory", "total_memory","dashicons-chart-pie","hc");
    m8c_variable_entry( $m8c_heatwave_sys_mem['available'], "Available", "available","dashicons-chart-bar","hc");
    m8c_variable_entry( $m8c_heatwave_sys_mem['use_percent']."%", "Used", "use_percent","dashicons-chart-line","hc");
    m8c_variable_entry( $m8c_heatwave_sys_mem['memory_free'], "Memory Free", "memory_free","dashicons-chart-bar","hc");
    m8c_variable_entry( $m8c_heatwave_sys_mem['memory_fs_cache'], "Memory File System Cache", "memory_fs_cache","dashicons-controls-play","hc");
    m8c_variable_entry( $m8c_heatwave_sys_mem['swap_total'], "Swap Total", "swap_total","dashicons-download","hc");
    m8c_variable_entry( $m8c_heatwave_sys_mem['swap_free'], "Swap Free", "swap_free","dashicons-dismiss","hc");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>Health Checker Block Device</legend> 
  <table width="100%">
	<?php
    m8c_variable_entry( $m8c_heatwave_disk['mount_point'], "Mount Point", "total_memory","dashicons-chart-pie","hc");
    m8c_variable_entry( $m8c_heatwave_disk['device'], "Filesystem", "device","dashicons-database-import","hc");
    m8c_variable_entry( $m8c_heatwave_disk['total_bytes'], "Total Size", "total_bytes","dashicons-database","hc");
    m8c_variable_entry( $m8c_heatwave_disk['available_bytes'], "Free Size", "available_bytes","dashicons-database-view","hc");
    m8c_variable_entry( $m8c_heatwave_disk['use_percent']."%", "Used", "use_percent","dashicons-chart-line","hc");
	?>
  </table>
</fieldset>
</div>