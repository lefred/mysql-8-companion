<?php
/**
 * @package MySQL8_Companion
 * @version 0.0.2
 */

defined( 'WPINC' ) || die;

/**
 * Get template content
 *
 * @param string $template_path Template path
 * @param array $args Template arguments
 * @param boolean $echo Print template content
 *
 * @return string
 */
function m8c_template( $template_path, $args = array(), $echo = false ) {

	$template_path = $template_path . '.php';

	ob_start();

	m8c_inc( $template_path, $args );

	if ( ! $echo ) {
		return ob_get_clean();
	}

	return ob_get_clean();

}

/**
 * Print template content
 *
 * @param string $template_path Template path
 * @param array $args Template arguments
 * @param boolean $echo Print template content
 *
 * @return string
 */
function m8c__template( $template_path, $args = array() ) {

	echo m8c_template( $template_path, $args, true );

}

/**
 * Create the function to output the content of our Dashboard Widget.
 */
function mysql8_companion_widget_render() {
	m8c__template( 'templates/admin/widget' );

}

function m8c_printr( $obj, $title = '' ) {

	echo '<pre>';
	echo '<h3>' . esc_html($title) . '</h3>';
	print_r( $obj );
	echo '</pre>';

}


/**
 * Get the full version of the database server
 *
 * @return string|null
 */
function m8c_getFullDatabaseVersion() {
	global $wpdb;

	return $wpdb->get_var( "SELECT VERSION();" );
}

/**
 * Get the full version comment of the database server
 *
 * @return string|null
 */
function m8c_getFullCommentDatabaseVersion() {
	global $wpdb;

	return $wpdb->get_var( "SELECT @@version_comment;" );
}

/**
 * Check if the server is MySQL or not
 *
 * @return bool
 */
function m8c_isMySQL( $versionString = '' ) {
	if ( empty( $versionString ) ) {
		$versionString = m8c_getFullCommentDatabaseVersion();
	}
	$isMySQL = false;
	if ( stripos( $versionString, 'MySQL' ) > - 1 ) {
		$isMySQL = true;
	}

	return $isMySQL;
}

/**
 * Check if the server is MySQL Cloud on OCI
 *
 * @return bool
 */
function m8c_isCloud( $versionString = '' ) {
	if ( empty( $versionString ) ) {
		$versionString = m8c_getFullCommentDatabaseVersion();
	}
	$isCloud = false;
	if ( stripos( $versionString, 'Cloud' ) > - 1 ) {
		$isCloud = true;
	}

	return $isCloud;
}


/**
 * Check the database version and compare the end of life date for MySQL
 * returns an array with all the information
 *
 * @return array
 */
function m8c_getAllDbInformation() {
	$debug = false;
	global $wpdb;
	$GeneralData = new M8C\GeneralData();
	$gd          = $GeneralData->get();
	$data        = [
		'fullVersion' => m8c_getFullDatabaseVersion(),
		'eol'         => '',
		'isEndOfLife' => false,
		'isCloud'     => false,
		'sysAccess'   => true,
		'pfsAccess'   => true,
	];
	$data['isMySQL'] = m8c_isMySQL();
	if ( $data['isMySQL'] ) {
       $data['isCloud'] = m8c_isCloud();
	}
	if ( isset( $gd['innodb_version'] ) ) {
		$data['dbVersion'] = $gd['innodb_version'];
	} else {
		$versionSplit      = explode( '-', $data['fullVersion'] );
		$data['dbVersion'] = $versionSplit[0] ?: '';
	}
	$versionSplit2          = explode( '.', $data['dbVersion'] );
	$data['dbVersionShort'] = $versionSplit2[0] ?: '';
	$data['dbVersionShort'] .= '.';
	$data['dbVersionShort'] .= $versionSplit2[1] ?: '0';

	if ( $data['isMySQL'] ) {
		$table_name = $wpdb->prefix . 'm8c_versions';
		$query      = "SELECT * from " . $table_name . ' where version = \'' . $data['dbVersionShort'] . '\'';
		$record     = $wpdb->get_results( $query, ARRAY_A );
		if ( isset( $record[0]['version'], $record[0]['eol'] ) ) {
			$data['eol']         = $record[0]['eol'];
			$data['isEndOfLife'] = m8c_checkEndOfLife( $record[0]['eol'] );
		}
	}

	// check is user has access to pfs and sys
	$query = "select mysql_version from sys.version;";
    $wpdb->get_results($query, ARRAY_A);
    if($wpdb->last_error != '') {
        if (str_contains($wpdb->last_error, "command denied")) {
			$data['sysAccess'] = false;
		}
	}
	$query = "select user from performance_schema.users limit 1;";
    $wpdb->get_results($query, ARRAY_A);
    if($wpdb->last_error != '') {
        if (str_contains($wpdb->last_error, "command denied")) {
			$data['pfsAccess'] = false;
		}
	}
	$query = "select user()";
    $res = $wpdb->get_results($query, ARRAY_A);
    if ($res) {
		$data['dbuser'] = $res[0]['user()'];
	}


	return $data;
}

/**
 * Check if a date is in the past or not
 *
 * @param string $date
 *
 * @return bool
 */
function m8c_checkEndOfLife( $date ) {
	$dateTime = strtotime( $date );

	if ( time() > $dateTime ) {
		return true;
	}

	return false;
}

/**
 * Generate entries 
 * 
 * @param string display_name
 * @param string var_name
 * @param string var_type default 'sysvar'
 * 
 * @return false;
 */
function m8c_variable_entry( $var_value, $display_name, $var_name, $icon="dashicons-info", $var_type='sysvar')
{
	$tooltip="No message yet";
	if( isset( $var_value ) ) {
	?>
		<tr>
			<?php
			  if ($var_type == "sysvar") {
				?>
			    <td><a href="https://dev.mysql.com/doc/refman/8.0/en/server-system-variables.html#sysvar_<?php echo $var_name; ?>" target="_blank" title="<?php _e("$tooltip", 'mysql8-companion' ); ?>"><small><span class="dashicons <?php echo $icon; ?>"></span></small></a> <?php
				/* translators: Specifies the name of the error log. */
				_e( "$display_name", 'mysql8-companion' );
			  } elseif ($var_type == "innodb") {
				?>
			    <td><a href="https://dev.mysql.com/doc/refman/8.0/en/innodb-parameters.html#sysvar_<?php echo $var_name; ?>" target="_blank" title="<?php _e("$tooltip", 'mysql8-companion' ); ?>"><small><span class="dashicons <?php echo $icon; ?>"></span></small></a> <?php
				/* translators: Specifies the name of the error log. */
				_e( "$display_name", 'mysql8-companion' );
			  } else {
				?>
			    <td><a href="" title="<?php _e("$tooltip", 'mysql8-companion' ); ?>"><small><span class="dashicons <?php echo $icon; ?>"></span></small></a> <?php
				/* translators: Specifies the name of the error log. */
				_e( "$display_name", 'mysql8-companion' );
			  }
			?></td>
			<td><?php echo esc_html($var_value); ?></td>
		</tr>
	<?php
	}
	
	return false;
}

/**
 * Format bytes in human readable value
 * 
 * @param int B 
 * @param int D
 * 
 * @return string;
 */
function m8c_format_bytes($B, $D=2){
	if ( $B == 18446744073709551615 ){
		return "NO LIMIT";
	}
	if ( $B == 0 ){
		return "0";
	}
    $S = 'kMGTPEZY';
    $F = floor((strlen($B) - 1) / 3);
    return sprintf("%.{$D}f", $B/pow(1024, $F)).' '.@$S[$F-1].'B';
}
