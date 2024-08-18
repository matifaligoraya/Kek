<?php
class WPBakeryKekTestimonialsElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_testimonials', array($this, 'render_kek_testimonials'), 40);
    }

    public function register_elements() {
        // Register the Testimonials Element
        vc_map(array(
            'name' => __('Kek Testimonials', 'kek'),
            'base' => 'kek_testimonials',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(                
                array(
                    'type' => 'textfield',
                    'heading' => __('Number of Testimonials', 'kek'),
                    'param_name' => 'number',
                    'description' => __('Enter the number of testimonials to display.', 'kek'),
                    'admin_label' => true,
                ),
            ),
        ));
    }

    public function render_kek_testimonials($atts) {
        $atts = shortcode_atts(array(           
            'number' => 3,
        ), $atts);        

        // Fetch testimonials
        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => intval($atts['number']),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $testimonials = new WP_Query($args);

        ob_start();
        ?>
        <!-- Testimonials -->        
        <section class="kek-testimonials kek-slider">
            <div class="container data-wrapper">               
                <div class="owl-carousel owl-theme">
                    <div class="t-bq-section row">
                    <?php if ($testimonials->have_posts()) : ?>
                        <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>     
                        <?php
                            $user_img = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');

                            if ($user_img) {
                                $user_img = esc_url($user_img);
                            }

                            $style = !empty($user_img) ? "style=\" background-image: url(' " . $user_img . " ') \" " : "style=\" background-image: url(' " . kek_DIR . "assets/images/user.png') \" ";
                        ?>
                        <div class="t-bq-wrapper t-bq-wrapper-boxed">
                            <div class="t-bq-quote t-bq-quote-kek-testimonial-1">                                    
                                <div class="t-bq-quote-kek-testimonial-1-userpic" <?php echo $style; ?>>
                                </div>
                                <div class="t-bq-quote-kek-testimonial-1-qmark">&#10077;</div>                         
                                <div class="t-bq-quote-kek-testimonial-1-pattern"></div>       
                                <div class="t-bq-quote-kek-testimonial-1-base">
                                    <blockquote class="t-bq-quote-kek-testimonial-1-text" cite="Strugatsky Brothers">
                                        <?php the_content(); ?>
                                    </blockquote>
                                    <div class="t-bq-quote-kek-testimonial-1-meta">
                                        <div class="t-bq-quote-kek-testimonial-1-meta-info">
                                            <div class="t-bq-quote-kek-testimonial-1-author">
                                                <cite>
                                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_kek_testimonial_name', true)); ?>, 
                                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_kek_testimonials_niche', true)); ?>
                                                </cite>
                                            </div>
                                            <div class="t-bq-quote-kek-testimonial-1-source">
                                                <?php echo esc_html(get_post_meta(get_the_ID(), '_kek_testimonials_followers', true)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p><?php _e('No testimonials found.', 'kek'); ?></p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                    </div>
                </div>   
            </div>
        </section>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekTestimonialsElement();