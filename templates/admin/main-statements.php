<h3><?php _e( 'MySQL Satements Analysis', 'mysql8-companion' ); ?></h3>
<?php
    $active_stab = isset($_GET['stab']) ? sanitize_text_field(strval($_GET['stab'])) : 'expensive';
?>
<h4 class="nav-tab-wrapper">
	<a href="?page=m8c&tab=pfs2&stab=expensive" class="nav-tab <?php echo 'expensive' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Most Expensive', 'mysql8-companion'); ?></a>
	<a href="?page=m8c&tab=pfs2&stab=slowest" class="nav-tab <?php echo 'slowest' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Slowest', 'mysql8-companion'); ?></a>
	<a href="?page=m8c&tab=pfs2&stab=fullscan" class="nav-tab <?php echo 'fullscan' === $active_stab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Full Table Scan', 'mysql8-companion'); ?></a>
</h4>
<?php
if ('expensive' === $active_stab) {
	require_once("pfs/pfs2-expensive.php");
}
if ('slowest' === $active_stab) {
	require_once("pfs/pfs2-slowest.php");
}
if ('fullscan' === $active_stab) {
	require_once("pfs/pfs2-fullscan.php");
}
unset( $m8c_pfs );
?>
</div>