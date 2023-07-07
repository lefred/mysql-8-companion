<?php
	$dbInformation = m8c_getAllDbInformation();
?>
<h2><?php _e( 'MySQL 8 Companion', 'mysql8-companion' ); ?></h2>
<div class="wrap">
	<?php settings_errors(); ?>
	<?php m8c__template('templates/admin/notices'); ?>
	<?php $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field(strval( $_GET['tab'] )) : 'general'; ?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=m8c&tab=general" class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'mysql8-companion' ); ?></a>
		<a href="?page=m8c&tab=pfs" class="nav-tab <?php echo 'pfs' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Performance_Schema', 'mysql8-companion' ); ?></a>
		<a href="?page=m8c&tab=pfs2" class="nav-tab <?php echo 'pfs2' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Statements', 'mysql8-companion' ); ?></a>
		<div class="m8clogo">
			<?php
			   if ( $dbInformation['isCloud'] ) {
	 			_e("<img src='" . m8c_url('images/mds.png') . "'>");
		    ?>
			<a href="?page=m8c&tab=heatwave" class="nav-tab <?php echo 'heatwave' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'HeatWave', 'mysql8-companion' ); ?></a>
			<?php
			   } else {
	 			_e("<img align='right' src='" . m8c_url('images/mysql.png') . "'>");
			   }
			?>
		</div>
	</h2>
	<?php
	if ('general' === $active_tab) {
		m8c__template('templates/admin/main-general');
	}
	if ( 'pfs' === $active_tab ) {
		m8c__template( 'templates/admin/main-pfs' );
	}
	if ( 'pfs2' === $active_tab ) {
		m8c__template( 'templates/admin/main-statements' );
	}
	if ( 'heatwave' === $active_tab ) {
		m8c__template( 'templates/admin/main-heatwave' );
	}
	?>
</div>
