<?php
   $m8c_pfs = new M8C\Pfs2();
   $m8c_pfs_slow = $m8c_pfs->getSlowest();
  
?>
<fieldset class="m8c-error" >
  <legend>Slowest Queries</legend> 
  <table width="100%">
            <tr>
                <th>
                    Total Latency
                </th>
                <th>
                    Executed Count
                </th>
                <th>
                    Latency per Call
                </th>
                <th>
                    First Seen
                </th>
                <th>
                    Last Seen
                </th>
                <th>
                    Query Sample
                </th>
            </tr>
            <?php
              foreach ($m8c_pfs_slow as $row) {
                echo("<tr><td>".$row['tot_lat']."</td><td>"); 
                echo($row['exec_count']."</td><td>"); 
                echo($row['latency_per_call']."</td><td>"); 
                echo($row['first_seen']."</td><td>"); 
                echo($row['last_seen']."</td><td>");                
                echo '<p class="cell-data" data-id="'.$row['digest'].'">';
                echo '<span class="m8c-little-arrow"></span>';
                echo(substr($row['query'],0,128)."</p></td></tr>"); 
                echo "<tr class='query-line' id='".$row['digest']."'><td colspan=6>";
                echo "</td><td><button class='m8c-qep' data-id='". $row['digest'] ."'>Query Execution Plan</button><span class='spinner'></span></td></tr>";
              }          
            ?>
  </table>
  <?php
  ?>
</fieldset>