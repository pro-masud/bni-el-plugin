<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class BNI_WID_Register {

    // Auto-scan widgets folder and return PHP files
    public static function get_widgets_list() {
        $dir = BNI_WID_DIR . 'widgets/';
        $files = [];
        if ( is_dir( $dir ) ) {
            foreach ( scandir( $dir ) as $f ) {
                if ( in_array( $f, ['.', '..'] ) ) continue;
                if ( pathinfo( $f, PATHINFO_EXTENSION ) === 'php' ) {
                    $files[] = $f;
                }
            }
        }
        return $files;
    }

    // Convert filename to class name, e.g. hero-widget.php -> BNI_Hero_Widget
    public static function get_widget_class_name( $file ) {
        $name = str_replace( '.php', '', $file );
        $parts = preg_split('/[-_]+/', $name);
        $parts = array_map( 'ucfirst', $parts );
        return 'BNI_' . implode( '_', $parts );
    }
}
