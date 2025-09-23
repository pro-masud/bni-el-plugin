<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BNI_WID_Enqueue {

    public static function init() {
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'frontend_assets' ] );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_assets' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ __CLASS__, 'editor_assets' ] );
    }

    public static function frontend_assets() {
        // Bootstrap CDN
        wp_register_style( 'bni-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', [], '5.3.2' );
        wp_enqueue_style( 'bni-bootstrap-css' );
        wp_enqueue_style( 'bni-style', BNI_WID_URL . 'assets/css/bni-style.css', [], BNI_WID_VERSION );

        wp_enqueue_script( 'bni-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', [ 'jquery' ], '5.3.2', true );
        wp_enqueue_script( 'bni-isotope-js', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', [ 'jquery' ], '2.0', true );
        wp_enqueue_script( 'bni-script', BNI_WID_URL . 'assets/js/bni-script.js', [ 'jquery' ], BNI_WID_VERSION, true );
    }

    public static function editor_assets() {
        wp_enqueue_style( 'bni-bootstrap-css' );
        wp_enqueue_style( 'bni-style' );

        wp_enqueue_script( 'bni-bootstrap-js' );
        wp_enqueue_script( 'bni-isotope-js' );
        wp_enqueue_script( 'bni-script' );
    }

    public static function admin_assets() {
        // Admin assets if needed
    }
}
