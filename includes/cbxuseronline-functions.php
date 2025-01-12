<?php

/**
 * The file that defines the custom functions of the plugin
 *
 *
 *
 * @link       codeboxr.com
 * @since      1.2.10
 *
 * @package    cbxuseronline
 * @subpackage cbxuseronline/includes
 */

if ( ! function_exists( 'cbxuseronline_load_svg' ) ) {
	/**
	 * Load an SVG file from a directory.
	 *
	 * @param  string  $svg_name  The name of the SVG file (without the .svg extension).
	 * @param  string  $directory  The directory where the SVG files are stored.
	 *
	 * @return string|false The SVG content if found, or false on failure.
	 * @since 1.0.0
	 */
	function cbxuseronline_load_svg( $svg_name = '', $folder = '') {
		if ( $svg_name == '' ) {
			return '';
		}


		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$credentials = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, false, null );
		if ( ! WP_Filesystem( $credentials ) ) {
			return ''; // Error handling here
		}

		global $wp_filesystem;


		$directory = cbxuseronline_icon_path();

		// Sanitize the file name to prevent directory traversal attacks.
		$svg_name = sanitize_file_name( $svg_name );
		if($folder != ''){
			$folder = trailingslashit($folder);
		}

		// Construct the full file path.
		$file_path = $directory. $folder . $svg_name . '.svg';
		$file_path = apply_filters( 'cbxuseronline_svg_file_path', $file_path, $svg_name );

		// Check if the file exists.
		if ( $wp_filesystem->exists( $file_path ) && is_readable( $file_path ) ) {
			// Get the SVG file content.
			return $wp_filesystem->get_contents( $file_path );
		} else {
			// Return false if the file does not exist or is not readable.
			return '';
		}
	}//end method cbxuseronline_load_svg
}

if ( ! function_exists( 'cbxuseronline_icon_path' ) ) {
	/**
	 * Resume icon path
	 *
	 * @return mixed|null
	 * @since 1.0.0
	 */
	function cbxuseronline_icon_path() {
		$directory = trailingslashit( CBX_USERONLINE_PLUGIN_ROOT_PATH ) . 'assets/icons/';

		return apply_filters( 'cbxuseronline_icon_path', $directory );
	}//end method cbxuseronline_icon_path
}