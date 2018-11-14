<?php if( ! defined( 'ABSPATH' ) ) { die; }

if( ! function_exists( 'tutty_locate' ) ) {
    function tutty_locate() {
        $dirname        = wp_normalize_path( dirname( __FILE__ ) );
        $plugin_dir     = wp_normalize_path( WP_PLUGIN_DIR );
        $located_plugin = ( preg_match( '#'. preg_replace( '/[^A-Za-z]/', '', $plugin_dir ) .'#', preg_replace( '/[^A-Za-z]/', '', $dirname ) ) ) ? true : false;
        $directory      = ( $located_plugin ) ? $plugin_dir : get_template_directory();
        $directory_uri  = ( $located_plugin ) ? WP_PLUGIN_URL : get_template_directory_uri();
        $basename       = str_replace( wp_normalize_path( $directory ), '', $dirname );
        $dir            = $directory . $basename;
        $uri            = $directory_uri . $basename;

        return array(
            'basename' => wp_normalize_path( $basename ),
            'dir'      => wp_normalize_path( $dir ),
            'uri'      => $uri
        );
    }
}

if( ! function_exists( 'tutty_get_file' ) ) {
    function tutty_get_file( $file ) {
        $file = TT_PATH . '/' . $file;
        if( file_exists( $file ) ) {
            require_once $file;
        }
    }
}

if( ! function_exists( 'tutty_admin_enqueue' ) ) {
    function tutty_admin_enqueue() {
        wp_enqueue_style( 'tutty', TT_URL . '/assets/tutty_metabox.css' );
        wp_enqueue_script( 'tutty', TT_URL . '/assets/tutty_metabox.js' );
    }

    add_action( 'admin_enqueue_scripts', 'tutty_admin_enqueue' );
}