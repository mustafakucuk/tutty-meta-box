<?php if( ! defined( 'ABSPATH' ) ) { die; }
/**
 * 
 * ------------------------------------------------------------------------------------------------
 * 
 * Plugin Name: Tutty Meta Box Framework
 * Description: Create custom fields with simple and easy to use WordPress meta box framework.
 * Author: Mustafa KÜÇÜK
 * Author URI: https://mustafakucuk.net
 * Version: 1.0
 * License: GPLv2 or later
 * 
 * ------------------------------------------------------------------------------------------------
 * 
 */

require_once plugin_dir_path( __FILE__ ) . '/tutty-metabox-framework-helper.php';

define( 'TT_PATH', tutty_locate()['dir'] );
define( 'TT_URL', tutty_locate()['uri'] );

tutty_get_file( 'inc/tutty-metabox.class.php' );
tutty_get_file( 'tutty-metabox-fields.php' );