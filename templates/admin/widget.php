<?php
$dbInformation = m8c_getAllDbInformation();
$isMySQL = null;
if ( $dbInformation['isMySQL'] ) {
	$isMySQL = '(MySQL)';
}
?>
<p><?php printf(
		/* translators: %1$s: The database version you want. */
				__( 'You are currently using version <strong>%1$s</strong> of your %2$s server.', 'mysql8-companion' ),
				$dbInformation['dbVersion'],
				$ismysql
		); ?>
	</p>
<?php if ( $dbInformation['isEndOfLive'] ) { ?>
		<p><?php _e( 'Your version is past end of life. Please update your MySQL database to a newer version.', 'mysql8-companion' ); ?></p>
		<p><?php printf(
					__( 'Please, <a href="%1$s" target="_blank">download an updated version of MySQL</a>.', 'mysql8-companion' ),
					$nysqlDBUrlDownload,
			); ?></p>
<?php } else { ?>
		<p><?php printf(
					__( 'The version of your MySQL is fully supported until <strong>%1$s</strong>.', 'mysql8-companion' ),
					$dbInformation['eol'],
			); ?></p>
<?php } ?>
<p><a href="tools.php?page=m8c&tab=general" class="button button-primary"><?php _e( 'Go to MySQL 8 Companion page', 'mysql8-companion' ); ?></a></p>
