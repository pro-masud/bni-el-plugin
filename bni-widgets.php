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

   
    ?>
    <section class="bni-case swiper bni-col-slider mt-4">
        <div class="swiper-wrapper">
            <?php
                if ($collaboration_partner_collaboration) {
                    foreach ((array) $collaboration_partner_collaboration as $single_col) {
                        $single_col_id = is_object($single_col) ? $single_col->ID : (int) $single_col;

                        $collaborators_title = get_field('collaborators_title', $single_col_id);
                        $button_text = get_field('button_text', $single_col_id);

                        $permalink = get_permalink($single_col_id);
                        $title     = get_the_title($single_col_id);

                        $content   = get_post_field('post_content', $single_col_id);
                        $excerpt   = wp_trim_words( wp_strip_all_tags($content), 13, '…' );
                        ?>
                            <div class="bni-card swiper-slide">
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
                }else{
                    ?>
                        <p class="mt-4"><?php echo esc_html('No collaboration posts found.'); ?></p>
                    <?php 
                }
            ?>
        </div>
    </section>
    <div class="bni-coll-controls">
        <button type="button" class="bni-nav bni-event-prev">
            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 1L1 9L9 17" stroke="#4E0B11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <button type="button" class="bni-nav bni-event-next">
            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L9 9L1 17" stroke="#4E0B11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
    <?php
}


add_shortcode('collaboration_partner_collaboration_post', 'collaboration_partner_collaboration_post');


function upcoming_event_post() {
    // Get relationship field (ACF) that lists case studies/posts
    $upcoming_events = get_field('upcoming_events');
    ?>
    <section class="bni-case swiper section-tap-events bni-event-slider mt-4">
        <div class="bni-event-slider-wrapper swiper-wrapper">
                <?php
                    if ($upcoming_events) {
                        foreach ((array) $upcoming_events as $single_event) {
                            $single_event_id = is_object($single_event) ? $single_event->ID : (int) $single_event;

                            $button_text = get_field('button_text', $single_event_id);
                            $event_date = get_field('event_date', $single_event_id);

                            $permalink = get_permalink($single_event_id);
                            $title     = get_the_title($single_event_id);

                            $content   = get_post_field('post_content', $single_event_id);
                            $excerpt   = wp_trim_words( wp_strip_all_tags($content), 7, '…' );
                            ?>

                            <div class="bni-item bni-evnet-item swiper-slide">
                                <div class="bni-event-image">
                                    <?php  echo get_the_post_thumbnail(  $single_event_id, 'medium',  array('alt' => esc_attr($title))  ); ?>
                                </div>
                                <div class="bni-event-content">
                                    <h5 class="card-title"> <?php echo esc_html($title); ?></h5>
                                    <p class="card-text"><?php echo esc_html($excerpt); ?></p>
                                    <div class="bni-event-meta">
                                        <button class="btn my-rsvp-popup" onclick="elementorProFrontend.modules.popup.showPopup({id:3972}); return false;"><?php echo esc_html($button_text); ?></button>
                                        <p><?php echo wp_kses_post($event_date); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                            <p class="mt-4"><?php echo esc_html('No Events posts found.'); ?></p>
                        <?php 
                    }
                ?>
        </div>
    </section>
    <div class="bni-event-controls">
        <button type="button" class="bni-nav bni-event-prev">
            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 1L1 9L9 17" stroke="#4E0B11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <button type="button" class="bni-nav bni-event-next">
            <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L9 9L1 17" stroke="#4E0B11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
    <?php
}


add_shortcode('upcoming_event_post', 'upcoming_event_post');


function upcoming_deals_post() {
    // Get relationship field (ACF) that lists case studies/posts
    $exclusive_deals_post = get_field('exclusive_deals_post');
    ?>
            <div class="bni-deal-slider-section swiper bni-swiper mt-4">
                <div class="bni-deal-slider swiper-wrapper">
                            <?php
                    if ($exclusive_deals_post) {
                        foreach ((array) $exclusive_deals_post as $single_event) {
                            $single_event_id = is_object($single_event) ? $single_event->ID : (int) $single_event;

                            $button_text = get_field('button_text', $single_event_id);
                            $event_date = get_field('event_date', $single_event_id);

                            $permalink = get_permalink($single_event_id);
                            $title     = get_the_title($single_event_id);

                            $content   = get_post_field('post_content', $single_event_id);
                            $excerpt   = wp_trim_words( wp_strip_all_tags($content), 7, '…' );
                            ?>
                                <div class="swiper-slide">
                                    <div class="deal-card bni-deal-single" style="background-image: url('<?php echo esc_url( plugins_url('assets/image/frame-81.png', __FILE__) ); ?>');">
                                        <?php  echo get_the_post_thumbnail(  $single_event_id, 'medium',  array('alt' => esc_attr($title))  ); ?>
                                        <div class="deal-content">
                                            <h5><?php echo esc_html($title); ?></h5>
                                            <p><?php echo esc_html($excerpt); ?></p>
                                            <a class="btn bni-text"><?php echo esc_html($button_text); ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    }else{
                        ?>
                            <p class="mt-4"><?php echo esc_html('No Deal posts found.'); ?></p>
                        <?php 
                    } ?>
                </div>
            </div>

             <div class="bni-controls">
                <button type="button" class="bni-nav bni-prev">
                    <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 1L1 9L9 17" stroke="#4E0B11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button type="button" class="bni-nav bni-next">
                    <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L9 9L1 17" stroke="#4E0B11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        <?php
    }


add_shortcode('upcoming_deals_post', 'upcoming_deals_post');

