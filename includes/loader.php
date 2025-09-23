<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BNI_WID_Loader {
    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        // Enqueue assets
        require_once BNI_WID_DIR . 'includes/enqueue.php';
        BNI_WID_Enqueue::init();

        // Register category
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );

        // Register widgets - use the modern hook for widgets registration
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

        // Load helper
        require_once BNI_WID_DIR . 'includes/register-widgets.php';
    }

    public function register_category( $elements_manager ) {
        if ( method_exists( $elements_manager, 'add_category' ) ) {
            $elements_manager->add_category(
                'bni-widgets',
                [
                    'title' => 'BNI Widgets',
                    'icon' => 'fa fa-plug'
                ]
            );
        }
    }

    public function register_widgets( $widgets_manager ) {
        $widgets = BNI_WID_Register::get_widgets_list();
        foreach ( $widgets as $file ) {
            $path = BNI_WID_DIR . 'widgets/' . $file;
            if ( file_exists( $path ) ) {
                require_once $path;
                $class = BNI_WID_Register::get_widget_class_name( $file );
                if ( class_exists( $class ) ) {
                    $widgets_manager->register( new $class() );
                }
            }
        }
    }
}
