<h3><?php _e( 'MySQL Performance Schema', 'mysql8-companion' ); ?></h3>
<?php
    $active_stab = isset($_GET['stab']) ? sanitize_text_field(strval($_GET['stab'])) : 'summary';
?>
<h4 class="nav-tab-wrapper">
	<a href="?page=m8c&tab=pfs&stab=summary" class="nav-tab <?php echo 'summary' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Summary', 'mysql8-companion'); ?></a>
	<a href="?page=m8c&tab=pfs&stab=schema" class="nav-tab <?php echo 'schema' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Schema Design', 'mysql8-companion'); ?></a>
</h4>
<?php
if ('summary' === $active_stab) {
	require_once("pfs/pfs-summary.php");
}
if ('schema' === $active_stab) {
	require_once("pfs/pfs-schema.php");
}
unset( $m8c_pfs );
?>
</div>