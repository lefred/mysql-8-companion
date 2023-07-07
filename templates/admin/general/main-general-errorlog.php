<?php
   $m8c_ErrorLog = new M8C\ErrorLog();

   $dir="desc";
   $limit=100;
   $offset=0;
   $prio="";
   $subsystem="";
   $logged="";

   if (isset($_GET['m8c-prio'])) $prio = $_GET['m8c-prio'];
   if (isset($_GET['m8c-subsystem'])) $subsystem = $_GET['m8c-subsystem'];
   if (isset($_GET['m8c-from'])) $logged = $_GET['m8c-from'];
   
   $m8c_err = $m8c_ErrorLog->get($logged, $dir, $limit, $offset, $prio, $subsystem);
?>
<fieldset class="m8c-error">
  <legend>Error Log</legend> 
  <form action="">
  <input type="hidden" id="page" name="page" value="m8c">
  <input type="hidden" id="tab" name="tab" value="general">
  <input type="hidden" id="stab" name="stab" value="logs">
  <table>
    <tr>
        <th>From</th><td>
        <input type="datetime-local" id="m8c-from" name="m8c-from" value="<?php echo $logged; ?>"></td>
        <th>Prio</th><td>
        <select id="m8c-prio" name="m8c-prio">
            <option value="">All</option>
            <option value="system" <?php if ($prio == "system") echo "selected"; ?>>System</option>
            <option value="note" <?php if ($prio == "note") echo "selected"; ?>>Note</option>
            <option value="warning <?php if ($prio == "warning") echo "selected"; ?>">Warning</option>
            <option value="error" <?php if ($prio == "error") echo "selected"; ?>>Error</option>
        </select>
        <th>Subsystem</th><td>
        <select id="m8c-subsystem" name="m8c-subsystem">
            <option value="">All</option>
            <option value="server" <?php if ($subsystem == "server") echo "selected"; ?>>Server</option>
            <option value="innodb" <?php if ($subsystem == "innodb") echo "selected"; ?>>InnoDB</option>
            <option value="repl" <?php if ($subsystem == "repl") echo "selected"; ?>>Repl</option>
        </select>
    </td><td><input type="submit" value="Search"></td></tr>
  </table>
  </form>
  <div class="m8c-container"> 
  <table class="m8c-logs">
    <tr><th>Logged</th><th>Thread Id</th><th>Prio</th><th>Error Code</th><th>Subsystem</th><th>Data</th><tr>
    <?php
    foreach ($m8c_err as $row) {
       echo("<tr><td>".$row['LOGGED']."</td><td>"); 
       echo($row['THREAD_ID']."</td><td>"); 
       echo($row['PRIO']."</td><td>"); 
       echo($row['ERROR_CODE']."</td><td>"); 
       echo($row['SUBSYSTEM']."</td><td>"); 
       echo($row['DATA']."</td></tr>"); 
    }
    ?>
  </table>
  </div>
</fieldset>