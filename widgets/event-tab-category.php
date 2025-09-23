<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class BNI_Event_Tab_Category extends Widget_Base {

    public function get_name() {
        return 'bni_event_tab_category';
    }

    public function get_title() {
        return 'BNI Event Tab Category';
    }

    public function get_icon() {
        return 'eicon-star';
    }

    public function get_categories() {
        return [ 'bni-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section('content', ['label' => 'Content']);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

  <!-- Filter Buttons -->
  <div class="container my-4">
    <div class="bni-filter-btns">
      <button class="btn active" data-filter="*">All</button>
        <?php
            $terms = get_terms(array(
                'taxonomy' => 'event-category',
                'hide_empty' => true,
            ));
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
        ?>
            <button class="btn" data-filter=".<?php echo esc_attr( str_replace( ' ', '-', $term->name ) ); ?>"><?php echo esc_html($term->name); ?></button>
        <?php } } ?>
    </div>
  </div>

    <!-- Gallery -->
    <div class="container">
        <div class="row bni-gallery">
            <?php
                $args = array(
                    'post_type'      => 'event',
                    'posts_per_page' => -1
                );
                $events = new WP_Query($args);

                if ($events->have_posts()) :
                while ($events->have_posts()) : $events->the_post();

                    $button_text = get_field('button_text');
                    $event_date = get_field('event_date');
                    $get_categorys = get_the_terms(get_the_ID(), 'event-category');

                    if ( !$get_categorys || is_wp_error( $get_categorys ) ) {
                        $get_categorys = [];
                    } else {
                        $get_categorys = $get_categorys[0]->name;
                    }
                    ?>
                        <div class="col-12 col-sm-6 col-lg-4 bni-item bni-evnet-item <?php echo esc_attr( str_replace( ' ', '-', $get_categorys ) ); ?>">
                            <div class="bni-event-image">
                                <?php echo get_the_post_thumbnail(); ?>
                            </div>
                            <div class="bni-event-content">
                                <div class="">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <p class="card-text"><?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
                                </div>
                                <div class="bni-event-meta">
                                    <button class="btn"><?php echo esc_html($button_text); ?></button>
                                    <p><?php echo wp_kses_post($event_date); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata();
                    else: ?>
                    <p>No upcoming events found.</p>
                <?php endif; ?>
        </div>
    </div>



        <?php
    }
}
