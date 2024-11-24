<?php
class WPBakeryKekHeroElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_hero', array($this, 'render_kek_hero'), 40);
    }

    public function register_elements() {
        // Register the Hero Element
        vc_map(array(
            'name' => __('Kek Hero Section', 'kek'),
            'base' => 'kek_hero',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'attach_image',
                    'heading' => __('Hero Background Image', 'kek'),
                    'param_name' => 'hero_bg',
                    'description' => __('Upload the background image for the hero section.', 'kek'),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Welcome Title', 'kek'),
                    'param_name' => 'welcome_title',
                    'value' => 'WELCOME',
                    'description' => __('Enter the welcome title text.', 'kek'),
                ),
                array(
                    'type' => 'textarea',
                    'heading' => __('Welcome Description', 'kek'),
                    'param_name' => 'welcome_desc',
                    'value' => 'We are a team of talented designers making websites with Bootstrap.',
                    'description' => __('Enter the description below the welcome title.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Why Box Title', 'kek'),
                    'param_name' => 'why_title',
                    'value' => 'Why Choose Us?',
                    'description' => __('Enter the title for the "Why Box".', 'kek'),
                ),
                array(
                    'type' => 'textarea',
                    'heading' => __('Why Box Description', 'kek'),
                    'param_name' => 'why_desc',
                    'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                    'description' => __('Enter the description for the "Why Box".', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Why Box Button Text', 'kek'),
                    'param_name' => 'why_button_text',
                    'value' => 'Learn More',
                    'description' => __('Enter the text for the button in the "Why Box".', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Why Box Button Link', 'kek'),
                    'param_name' => 'why_button_link',
                    'value' => '#about',
                    'description' => __('Enter the link for the button in the "Why Box".', 'kek'),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => __('Content Boxes', 'kek'),
                    'param_name' => 'content_boxes',
                    'description' => __('Add content for the boxes.', 'kek'),
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => __('Box Image', 'kek'),
                            'param_name' => 'box_image',
                            'description' => __('Upload an image for this box.', 'kek'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Box Title', 'kek'),
                            'param_name' => 'box_title',
                            'description' => __('Enter the title for this box.', 'kek'),
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => __('Box Description', 'kek'),
                            'param_name' => 'box_desc',
                            'description' => __('Enter the description for this box.', 'kek'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Button Text', 'kek'),
                            'param_name' => 'button_text',
                            'description' => __('Enter the text for the CTA button.', 'kek'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Button Link', 'kek'),
                            'param_name' => 'button_link',
                            'description' => __('Enter the URL for the CTA button.', 'kek'),
                        ),
                    ),
                ),
            ),
        ));
    }

    public function render_kek_hero($atts) {
        $atts = shortcode_atts(array(
            'hero_bg' => '',
            'welcome_title' => 'WELCOME',
            'welcome_desc' => 'We are a team of talented designers making websites with Bootstrap.',
            'why_title' => 'Why Choose Us?',
            'why_desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            'content_boxes' => '',
        ), $atts);

        // Get Hero Background Image
        $hero_bg_url = $atts['hero_bg'] ? wp_get_attachment_image_url($atts['hero_bg'], 'full') : '';

        // Parse Content Boxes
        $content_boxes = vc_param_group_parse_atts($atts['content_boxes']);

        ob_start();
        ?>
        <section id="hero" class="kek-hero section light-background">
                
            <!-- <?php if ($hero_bg_url): ?>
                <img src="<?php echo esc_url($hero_bg_url); ?>" alt="" data-aos="fade-in">
            <?php endif; ?> -->
            <div class="rotate-img">
            <img src="<?php echo kek_URI ?>assets/images/info-box-bg-light.svg" style="width: 32px;" >

                  <div class="rotate-sty-2"></div>
              </div>
            <div class="container position-relative">
            <div class="rotate-img">
                  
                    <div class="rotate-sty-2"></div>
                </div>
                <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
                    <h2><?php echo esc_html($atts['welcome_title']); ?></h2>
                    <p><?php echo esc_html($atts['welcome_desc']); ?></p>
                    <?php if (!empty($atts['why_button_text']) && !empty($atts['why_button_link'])): ?>
                            <div class="text-center">
                                <a href="<?php echo esc_url($atts['why_button_link']); ?>" class="more-btn">
                                    <span><?php echo esc_html($atts['why_button_text']); ?></span> 
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                </div><!-- End Welcome -->

                <div class="content row gy-4">
                    <div class="col-lg-4 d-flex align-items-stretch">
                        <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                            <h3><?php echo esc_html($atts['why_title']); ?></h3>
                            <p><?php echo wp_kses_post($atts['why_desc']); ?></p>
                        </div>
                    </div><!-- End Why Box -->

                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="row ">
                            <?php if (!empty($content_boxes)): ?>
                                <?php foreach ($content_boxes as $box): ?>
                                    <div class="col-xl-4 d-flex align-items-stretch">
                                        <div class="icon-box hover-zoom" data-aos="zoom-out" data-aos-delay="300">
                                            <?php if (!empty($box['box_image'])): ?>
                                                <img src="<?php echo wp_get_attachment_image_url($box['box_image'], 'full'); ?>" alt="" class="box-image">
                                            <?php endif; ?>
                                            <h4><?php echo esc_html($box['box_title']); ?></h4>
                                            <p><?php echo wp_kses_post($box['box_desc']); ?></p>
                                            <?php if (!empty($box['button_text']) && !empty($box['button_link'])): ?>
                                                <div class="text-center">
                                                    <a href="<?php echo esc_url($box['button_link']); ?>" class="button button-rounded ms-3 d-none d-sm-block"><?php echo esc_html($box['button_text']); ?></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div><!-- End Content Box -->
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="rotate-img">
     
                             <img src="<?php echo kek_URI ?>assets/images/send.png" style="width: 32px;" alt="Share Icon">
                            </div>
                        </div>
                    </div>
                  
                </div><!-- End Content -->
            </div>
            <div class="rotate-icon">
        <i class="bi bi-share-fill"></i>
    </div>

     <!-- Additional rotating shapes -->
    
        </section>
        <style>
            /*--------------------------------------------------------------
# Hero Section
--------------------------------------------------------------*/

.kek-hero {
  width: 100%;
  min-height: calc(100vh - 102px);
 padding-top: 20px !important;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.kek-hero img {
  position: absolute;
  inset: 0;
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 1;
}

.kek-hero .container {
  z-index: 3;
}

.kek-hero .welcome h2 {
  margin: 0;
  font-size: 48px;
  font-weight: 700;
  color: #fff;
}

.kek-hero .welcome p {
  font-size: 18px;
  margin: 0;
  color: #fff;
}

.kek-hero .content {
  margin-top: 40px;
}

.kek-hero .content .why-box {
  color: var(--kek-contrast-300);
  background: var(--kek-redish-100);
  padding: 30px;
  border-radius: 4px;
}

.kek-hero .content .why-box h3 {
  color: var(--kek-contrast-300);
  font-weight: 700;
  font-size: 34px;
  margin-bottom: 30px;
}

.kek-hero .content .why-box p {
  margin-bottom: 30px;
}

.kek-hero .content .why-box .more-btn {
  color: var(--kek-contrast-300);
  background: color-mix(in srgb, var(--kek-contrast-300), transparent 80%);
  display: inline-block;
  padding: 6px 30px 8px 30px;
  border-radius: 50px;
  transition: all ease-in-out 0.4s;
}

.kek-hero .content .why-box .more-btn i {
  font-size: 14px;
}

.kek-hero .content .why-box .more-btn:hover {
  background: var(--surface-color);
  color: var(--kek-themecolor);
}

.kek-hero .content .icon-box {
  text-align: center;
  border-radius: 10px;
  background: color-mix(in srgb, var(--surface-color), transparent 20%);
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
  padding: 40px 30px;
  width: 100%;
}

.kek-hero .content .icon-box i {
  font-size: 40px;
  color: var(--kek-themecolor);
}

.kek-hero .content .icon-box h4 {
  font-size: 20px;
  font-weight: 700;
  margin: 10px 0 20px 0;
}

.kek-hero .content .icon-box p {
  font-size: 15px;
  color: color-mix(in srgb, var(--default-color), transparent 30%);
}

.kek-hero  .align-items-stretch {
  align-items: stretch !important;
}
.kek-hero  .d-flex {
  display: flex !important;
}
img.box-image {
  width: 50px !important;
  height: 50px !important;
  margin: 0 auto;
  padding-top: 10px;
}
section.kek-hero {
  background-color: transparent;
 
}
            </style>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekHeroElement();
