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
                        <h3><a href="<?php echo get_permalink($profile->ID); ?>"><?php echo get_the_title($profile->ID); ?></a></h3>
                    </div>
                </div>
            <?php } ?>
        </div>

       <?php
    }
}

add_shortcode('show_related_profiles_two', 'show_related_profiles_two');


function show_related_single_profile() {
    $profiles = get_field('member'); 
    if( $profiles ) {
       ?>

        <div class="bni-team-member-wrapper bni-team-single-member">
            <?php foreach( $profiles as $profile ) { ?>
                <div class="bni-single-member">
                    <div class="bni-author-img">
                        <?php echo get_the_post_thumbnail($profile->ID); ?>
                    </div>
                    <div class="bni-content">
                        <h3><a href="<?php echo get_permalink($profile->ID); ?>"><?php echo get_the_title($profile->ID); ?></a></h3>
                    </div>
                </div>
            <?php } ?>
        </div>

       <?php
    }
}

add_shortcode('show_related_single_profile', 'show_related_single_profile');


function collaboration_partner_collaboration_post() {
    // Get relationship field (ACF) that lists case studies/posts
    $collaboration_partner_collaboration = get_field('collaboration_partner_collaboration');

    if (empty($collaboration_partner_collaboration)) {
        return;
    }
    ?>
    <section class="bni-case">
        <?php
        foreach ((array) $collaboration_partner_collaboration as $single_col) {
            $single_col_id = is_object($single_col) ? $single_col->ID : (int) $single_col;

            $collaborators_title = get_field('collaborators_title', $single_col_id);
            $button_text = get_field('button_text', $single_col_id);

            $permalink = get_permalink($single_col_id);
            $title     = get_the_title($single_col_id);

            $content   = get_post_field('post_content', $single_col_id);
            $excerpt   = wp_trim_words( wp_strip_all_tags($content), 13, '…' );
            ?>
            <div class="bni-card">
                <div class="bni-media">
                    <?php  echo get_the_post_thumbnail(  $single_col_id, 'medium',  array('alt' => esc_attr($title))  ); ?>
                </div>
                <div class="bni-content">
                    <h3 class="bni-title">
                        <?php echo esc_html($title); ?>
                    </h3>
                    <p class="bni-subtitle"><?php echo esc_html($excerpt); ?></p>
                    <div class="bni-collab-group">
                        <div class="bni-collab-title"><?php echo esc_html($collaborators_title); ?></div>

                        <?php $members = get_field('member', $single_col_id); ?>
                            <div class="bni-team-member-wrapper">
                                <?php foreach ((array) $members as $member) :
                                    $member_id    = is_object($member) ? $member->ID : (int) $member;
                                    $member_title = get_the_title($member_id);
                                    ?>
                                    <div class="bni-single-member">
                                        <div class="bni-author-img">
                                            <?php echo get_the_post_thumbnail( $member_id,  'thumbnail',  array('alt' => esc_attr($member_title)) ); ?>
                                        </div>
                                        <div class="bni-content">
                                            <a href="<?php echo esc_url(get_permalink($member_id)); ?>">
                                                <?php echo esc_html($member_title); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                    </div>
                    <a href="<?php echo esc_url($permalink); ?>" class="bni-btn"><?php echo esc_html($button_text); ?></a>
                </div>
            </div>
            <?php
        }
        ?>
    </section>
    <?php
}


add_shortcode('collaboration_partner_collaboration_post', 'collaboration_partner_collaboration_post');


