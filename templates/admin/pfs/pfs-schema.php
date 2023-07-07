<?php
   $m8c_pfs = new M8C\Pfs();
   $m8c_pfs_nopk = $m8c_pfs->getNoPK();
   $m8c_pfs_notusedidx_arr = $m8c_pfs->getNotUsedIdx();
   $m8c_pfs_notusedidx = $m8c_pfs_notusedidx_arr[0];
   $m8c_pfs_notusedidx_err = $m8c_pfs_notusedidx_arr[1];
   $m8c_pfs_dupidx_arr = $m8c_pfs->getDupIdx();
   $m8c_pfs_dupidx = $m8c_pfs_dupidx_arr[0];
   $m8c_pfs_dupidx_err = $m8c_pfs_dupidx_arr[1];
   $m8c_pfs_baddef = $m8c_pfs->getBadDefault();

?>
<fieldset class="m8c-error" >
  <legend>Tables without Primary Key</legend> 
  <?php
  if (count($m8c_pfs_nopk) > 0) {
    ?>
  <table width="100%">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_nopk as $row) {
                echo("<tr><td>".$row['TABLE_ID']."</td><td>"); 
                echo($row['TABLE_NAME']."</td></tr>>"); 
              }          
            ?>
  </table>
  <?php
  } else{
	esc_html_e('All good !');
  }
  ?>
</fieldset>

<fieldset class="m8c-error" >
  <legend>Not Used Indexes</legend> 
  <?php
  if (count($m8c_pfs_notusedidx) > 0) {
    ?>
  <table width="100%">
            <tr>
                <th>
                    Table Name
                </th>
                <th>
                    Index Name
                </th>
                <th>
                    Size
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_notusedidx as $row) {
                echo("<tr><td>".$row['table_name']."</td><td>"); 
                echo($row['index_name']."</td><td>"); 
                echo($row['size']."</td></tr>"); 
              }          
            ?>
  </table>
  <?php
  } else{
      if ($m8c_pfs_notusedidx_err) {
	    $my_msg = 'Missing permission !<p>Try: <tt>GRANT SELECT ON mysql.innodb_index_stats TO %1$s;';
        ?>
		<div class="notice notice-error">
		<?php
			printf(__($my_msg, 'mysql8-companion' ), DB_USER);?></p>
		</div>
        <?php
        esc_html_e('Some permissions are missing.');
      } else {
        esc_html_e('All good');
      }
  }
  ?>
</fieldset>

<fieldset class="m8c-error" >
  <legend>Duplicate Indexes</legend> 
  <?php
  if (count($m8c_pfs_dupidx) > 0) {
    ?>
  <table width="100%">
            <tr>
                <th>
                    Table Name
                </th>
                <th>
                    Redundant Index Name
                </th>
                <th>
                    Redundant Index Columns
                </th>
                <th>
                    Dominant Index Name
                </th>
                <th>
                    Dominant Index Columns
                </th>
                <th>
                    Size
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_dupidx as $row) {
                echo("<tr><td>".$row['table_name']."</td><td>"); 
                echo($row['redundant_index_name']."</td><td>"); 
                echo($row['redundant_index_columns']."</td><td>"); 
                echo($row['dominant_index_name']."</td><td>"); 
                echo($row['dominant_index_columns']."</td><td>"); 
                echo($row['size']."</td></tr>"); 
              }          
            ?>
  </table>
  <?php
  } else{
      if ($m8c_pfs_notusedidx_err) {
	    $my_msg = 'Missing permission !<p>Try: <tt>GRANT SELECT ON mysql.innodb_index_stats TO %1$s;';
        ?>
		<div class="notice notice-error">
		<?php
			printf(__($my_msg, 'mysql8-companion' ), DB_USER);?></p>
		</div>
        <?php
        esc_html_e('Some permissions are missing.');
      } else {
        esc_html_e('All good !');
      }
  }
  ?>
</fieldset>

<fieldset class="m8c-error" >
  <legend>Invalid Default Values</legend> 
  <?php
  if (count($m8c_pfs_baddef) > 0) {
    ?>
  <table width="100%">
            <tr>
                <th>
                    Table Name
                </th>
                <th>
                    Column Name
                </th>
                <th>
                    Data Type
                </th>
                <th>
                    Column's Default
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_baddef as $row) {
                echo("<tr><td>".$row['TABLE_NAME']."</td><td>"); 
                echo($row['COLUMN_NAME']."</td><td>"); 
                echo($row['DATA_TYPE']."</td><td>"); 
                echo($row['COLUMN_DEFAULT']."</td></tr>"); 
              }          
            ?>
  </table>
  <?php
  } else{
        esc_html_e('All good');
  }
  ?>
</fieldset>
