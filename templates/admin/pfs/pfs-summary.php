<?php
   $m8c_pfs = new M8C\Pfs();
   $m8c_pfs_summ = $m8c_pfs->getSumm();
   $m8c_pfs_toprw = $m8c_pfs->getTopRW();
   $m8c_pfs_topsize = $m8c_pfs->getTopSize();
   $m8c_pfs_optimize = $m8c_pfs->getTablesOptimize();
?>
<div class="m8c-grid">
<fieldset class="m8c">
  <legend>Read / Write Ratio</legend> 
  <table width="100%">
	<?php
    m8c_variable_entry( $m8c_pfs_summ['object_schema'], "WP database", "wp_database","dashicons-database","pfs");
    m8c_variable_entry( $m8c_pfs_summ['reads'], "Reads", "reads","dashicons-database-export","pfs");
    m8c_variable_entry( $m8c_pfs_summ['writes'], "Writes", "writes","dashicons-database-import","pfs");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>WP Database Size</legend> 
  <table width="100%">
	<?php
    m8c_variable_entry( $m8c_pfs_summ['ROWS'], "Rows", "wp_rows","dashicons-database","pfs");
    m8c_variable_entry( $m8c_pfs_summ['DATA'], "Data", "wp_data","dashicons-database","pfs");
    m8c_variable_entry( $m8c_pfs_summ['IDX'], "Idx", "wp_idx","dashicons-database","pfs");
    m8c_variable_entry( $m8c_pfs_summ['TOTAL_SIZE'], "Total", "wp_total","dashicons-database","pfs");
    m8c_variable_entry( $m8c_pfs_summ['FILE_SIZE'], "Files Size on Disk", "wp_file_size","dashicons-database","pfs");
    m8c_variable_entry( $m8c_pfs_summ['WASTED_SIZE'], "Wasted Space", "wp_wasted","dashicons-trash","pfs");
	?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>Read / Write Ratio Top 10</legend> 
  <table width="100%">
            <tr>
                <th>
                    Table name
                </th>
                <th>
                    Read
                </th>
                <th>
                    Writes
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_toprw as $row) {
                echo("<tr><td>".$row['object_name']."</td><td>"); 
                echo($row['reads']."</td><td>"); 
                echo($row['writes']."</td></tr>"); 
              }          
            ?>
  </table>
</fieldset>

<fieldset class="m8c">
  <legend>WP Database Size Top 10</legend> 
  <table width="100%">
            <tr>
                <th>
                    Table name
                </th>
                <th>
                    Rows
                </th>
                <th>
                    Data
                </th>
                <th>
                    Index
                </th>
                <th>
                    Total Size
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_topsize as $row) {
                echo("<tr><td>".$row['TABLE_NAME']."</td><td>"); 
                echo($row['ROWS']."</td><td>"); 
                echo($row['DATA']."</td><td>"); 
                echo($row['IDX']."</td><td>"); 
                echo($row['TOTAL SIZE']."</td></tr>"); 
              }          
            ?>
  </table>
</fieldset>  
</div>
<fieldset class="m8c-error-2">
  <legend>Top 10 Tables to Optimize</legend> 
    <table class="m8c-logs-2">
		<tr><th>Table Name</th>
		<th>Rows</th>
		<th>Data Size</th>
		<th>Index Size</th>
		<th>Total Size</th>
		<th>Data Free</th>
		<th>Size on Disk</th>
		<th>Wasted Size</th>
  </tr>
	<?php
	    foreach ($m8c_pfs_optimize as $row) {
          if ( $row['WASTED_SIZE_RAW'] > 99999) {
            echo("<tr><td>".$row['TABLE_NAME']."</td><td>"); 
            echo($row['TABLE_ROWS']."</td><td>"); 
            echo($row['DATA_SIZE']."</td><td>"); 
            echo($row['INDEX_SIZE']."</td><td>"); 
            echo($row['TOTAL_SIZE']."</td><td>"); 
            echo($row['DATA_FREE']."</td><td>"); 
            echo($row['FILE_SIZE']."</td><td>"); 
            echo($row['WASTED_SIZE']."</td></tr>");
          } 
    	}
	?>
  </table>
</fieldset>