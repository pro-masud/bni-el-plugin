<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class BNI_Team_Member extends Widget_Base {

    public function get_name() { return 'bni_team_member'; }
    public function get_title() { return 'BNI Team Member'; }
    public function get_icon() { return 'eicon-star'; }
    public function get_categories() { return [ 'bni-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section('content', ['label' => 'Content']);

        $this->add_control('team_data_title', [
            'label' => 'Title',
            'type' => Controls_Manager::TEXT,
            'default' => 'BNI Project'
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = $settings['team_data_title'] ?? 'BNI Project';
        ?>
            <?php
                // if ( is_singular('collaboration') ) { // শুধু single collaboration পোস্টের জন্য
                    $args = array(
                        'post_type'      => 'collaboration', // CPT slug
                        'posts_per_page' => -1, // সব পোস্ট দেখাবে
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    );

                    $collab_query = new WP_Query($args);

                    if ( $collab_query->have_posts() ) :
                        while ( $collab_query->have_posts() ) : $collab_query->the_post(); 
                            $profiles = get_field('member'); ?>
                            
                            <div class="collaboration-item">
                                <?php echo "<pre>"; ?>
                                    <?php print_r($profiles); ?>
                                <?php echo "</pre>"; ?>
                            </div>

                        <?php endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <p>No collaborations found.</p>
                    <?php endif;
                // }
            ?>

        <?php
    }
}
