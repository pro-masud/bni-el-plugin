<?php
/**
 * Plugin Name: BNI Widgets
 * Description: A lightweight plugin to register multiple Elementor widgets under a BNI category. Drop widget files into /widgets and they'll auto-register.
 * Version: 1.0.0
 * Author: Masud Rana
 * Text Domain: bni-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BNI_WID_VERSION', '1.0.0' );
define( 'BNI_WID_DIR', plugin_dir_path( __FILE__ ) );
define( 'BNI_WID_URL', plugin_dir_url( __FILE__ ) );

// Includes
require_once BNI_WID_DIR . 'includes/loader.php';

add_action( 'plugins_loaded', function() {
    // Check Elementor
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-warning"><p>BNI Widgets requires Elementor to be installed and activated.</p></div>';
        } );
        return;
    }
    BNI_WID_Loader::instance();
} );


function show_related_profiles() {
    $profiles = get_field('member'); // ACF relationship field
    if( $profiles ) {
       ?>

        <div class="bni-team-member-wrapper">
            <?php foreach( $profiles as $profile ) { ?>
                <div class="bni-single-member">
                    <div class="bni-author-img">
                        <?php echo get_the_post_thumbnail($profile->ID); ?>
                    </div>
                    <div class="bni-content">
                        <h3><a href="<?php echo get_permalink($profile->ID); ?>">K<?php echo get_the_title($profile->ID); ?></a></h3>
                    </div>
                </div>
            <?php } ?>
        </div>

       <?php
    }
}

add_shortcode('show_related_profiles', 'show_related_profiles');


function show_related_profiles_two() {
    $profiles = get_field('member'); 
    if( $profiles ) {
       ?>

        <div class="bni-team-member-wrapper bni-team-member-two">
            <?php foreach( $profiles as $profile ) { ?>
                <div class="bni-single-member">
                    <div class="bni-author-img">
                        <?php echo get_the_post_thumbnail($profile->ID); ?>
                    </div>
                    <div class="bni-content">
                        <h3><a href="<?php echo get_permalink($profile->ID); ?>">K<?php echo get_the_title($profile->ID); ?></a></h3>
                    </div>
                </div>
            <?php } ?>
        </div>

       <?php
    }
}

add_shortcode('show_related_profiles_two', 'show_related_profiles_two');


// Shortcode: [profile_categories]
function mj_profile_categories_shortcode() {

    $terms = get_terms(array(
        'taxonomy'   => 'category',
        'hide_empty' => true,
    ));

    if (empty($terms) || is_wp_error($terms)) {
        return '<p>No categories found.</p>';
    }

    $output = '<ul class="profile-categories">';
    foreach ($terms as $term) {
        $output .= '<li>';
        $output .= '<a href="' . esc_url(get_term_link($term)) . '">';
        $output .= esc_html($term->name);
        $output .= '</a>';
        $output .= '</li>';
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('profile_categories', 'mj_profile_categories_shortcode');


