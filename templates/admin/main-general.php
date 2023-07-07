<h3><?php _e( 'MySQL Database Information', 'mysql8-companion' ); ?></h3>
<?php
$dbInformation = m8c_getAllDbInformation();
$mysqlUrl         = 'https://dev.mysql.com/doc/relnotes/mysql/8.0/en/';
$mysqlUrlDownload = 'https://www.mysql.com/downloads/';
$m8c_GeneralData = new M8C\GeneralData();
$m8c_gd = $m8c_GeneralData->get();
$active_stab = isset($_GET['stab']) ? sanitize_text_field(strval($_GET['stab'])) : 'general';
$ismysql = null;
if ( $dbInformation['isMySQL'] ) {
	$ismysql = 'MySQL';
}
?>
<?php if ( $dbInformation['isEndOfLife'] ) { ?>
	<div class="notice notice-error">
		<p><?php _e( 'Your version is past end of life. Please update your MySQL database to a newer version.', 'mysql8-companion' ); ?></p>
		<p><?php printf(
			__( 'Please, <a href="%1$s" target="_blank">download an updated version of MySQL</a>.', 'mysql8-companion' ),
			$mysqlUrlDownload,
		); ?></p>
	</div>
<?php }
      $my_msg="";
      if ( ! $dbInformation['sysAccess'] && ! $dbInformation['pfsAccess']) {
        $my_msg = 'Your WordPress Database user does not have access to <strong>sys</strong> schema and <strong>performance_schema</strong>.'; 
		$my_msg2 = 'Please consider: <tt>GRANT SELECT ON sys.* TO %1$s; GRANT SELECT ON performance_schema.* TO %1$s;';
	  } elseif ( ! $dbInformation['sysAccess'] ) {
        $my_msg = 'Your WordPress Database user does not have access to <strong>sys</strong> schema.'; 
		$my_msg2 = 'Please consider: <tt>GRANT SELECT ON sys.* TO %1$s;';
	  } elseif ( ! $dbInformation['pfsAccess'] ) {
        $my_msg = 'Your WordPress Database user does not have access to <strong>performance_schema</strong>'; 
		$my_msg2 = 'Please consider: <tt>GRANT SELECT ON performance_schema.* TO %1$s;';
	  }
	  if ($my_msg) {
        ?>
		<div class="notice notice-error">
		    <p><?php _e( $my_msg, 'mysql8-companion' ); ?></p>
			<p><?php
			printf(__($my_msg2, 'mysql8-companion' ), $dbInformation['dbuser']);?></p>
		</div>
        <?php
      } 
?>
<h4 class="nav-tab-wrapper">
	<a href="?page=m8c&tab=general&stab=general" class="nav-tab <?php echo 'general' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Server Information', 'mysql8-companion'); ?></a>
	<a href="?page=m8c&tab=general&stab=logs" class="nav-tab <?php echo 'logs' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Error Logs', 'mysql8-companion'); ?></a>
	<a href="?page=m8c&tab=general&stab=conn" class="nav-tab <?php echo 'conn' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Connections', 'mysql8-companion'); ?></a>
	<a href="?page=m8c&tab=general&stab=innodb" class="nav-tab <?php echo 'innodb' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('InnoDB', 'mysql8-companion'); ?></a>
</h4>
<?php
if ('general' === $active_stab) {
	require_once("general/main-general-serverinfo.php");
}
if ('logs' === $active_stab) {
	require_once("general/main-general-errorlog.php");
}
if ('conn' === $active_stab) {
	require_once("general/main-general-connections.php");
}
if ('innodb' === $active_stab) {
	require_once("general/main-general-innodb.php");
}
unset( $m8c_gd );
?>
</div>
