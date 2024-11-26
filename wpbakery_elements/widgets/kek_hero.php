<?php
class WPBakeryKekHeroElement
{
  public function __construct()
  {
    add_action('vc_before_init', array($this, 'register_elements'), 40);
    add_shortcode('kek_hero', array($this, 'render_kek_hero'), 40);
  }

  public function register_elements()
  {
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

  public function render_kek_hero($atts)
  {
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

      <div class="container position-relative">

        <div class="content row ">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3><?php echo esc_html($atts['why_title']); ?></h3>
              <p><?php echo wp_kses_post($atts['why_desc']); ?></p>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="rotate-icon">
              <i class="bi bi-share-fill"></i>
            </div>

            <div class="kektag-list">

              <!-- YouTube Tags Slider -->
              <div class="loop-slider" style="--duration:7000ms; --direction:normal;">
                <div class="inner">
                  <div class="kektag"><i class="fab fa-youtube"></i> #Vlogs</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #Gaming</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #HowTo</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #Shorts</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #Challenges</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #Reviews</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #Tutorials</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #LiveStreams</div>
                  <div class="kektag"><i class="fab fa-youtube"></i> #Music</div>
                </div>
              </div>

              <!-- YouTube-Like Statistics Slider -->
              <div class="loop-slider" style="--duration:5000ms; --direction:reverse;">
                <div class="inner">
                  <div class="kektag">
                    <i class="fab fa-youtube"></i> 198K Subscribers
                  </div>
                  <div class="kektag">
                    <i class="fas fa-thumbs-up"></i> 12K Likes
                  </div>
                  <div class="kektag">
                    <i class="fas fa-share"></i> 5K Shares
                  </div>
                  <div class="kektag">
                    <i class="fas fa-comment"></i> 900 Comments
                  </div>
                  <div class="kektag">
                    <i class="fas fa-eye"></i> 1.5M Views
                  </div>
                </div>
              </div>

              <!-- Instagram-Like Statistics Slider -->
              <div class="loop-slider" style="--duration:10000ms; --direction:normal;">
                <div class="inner">
                  <div class="kektag">
                    <i class="fab fa-instagram"></i> 5K Followers
                  </div>
                  <div class="kektag">
                    <i class="fas fa-heart"></i> 300 Likes
                  </div>
                  <div class="kektag">
                    <i class="fas fa-comment"></i> 120 Comments
                  </div>
                  <div class="kektag">
                    <i class="fas fa-share"></i> 20 Shares
                  </div>
                  <div class="kektag">
                    <i class="fas fa-video"></i> 50 Reels
                  </div>
                </div>
              </div>



              <div class="fade"></div>
            </div>

            <div id="splash-illustration" class="col">
              <video id="splash-illustration-top-left" class="splash-illustration-canvas video-element--loaded"
                poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.webp"
                autoplay loop>
                <source type="video/webm" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.webm" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.webm">
                <source type="video/mp4; codecs=hevc" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.mp4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.mp4">
                <source type="video/mp4" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.mp4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.mp4">
              </video>
              <video id="splash-illustration-bottom-left" class="splash-illustration-canvas video-element--loaded"
                poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180parisoslo.webp"
                autoplay loop>
                <source type="video/webm" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/parisoslo_x180.webm" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/parisoslo_x180.webm">
                <source type="video/mp4; codecs=hevc" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/parisoslo_x180.mp4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/parisoslo_x180.mp4">
                <source type="video/mp4" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180parisoslo_x180.mp4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180parisoslo_x180.mp4">
              </video>
              <video id="splash-illustration-right" class="splash-illustration-canvas video-element--loaded"
                poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11.webp"
                autoplay loop>
                <source type="video/webm" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11_x180.webm" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11_x180.webm">
                <source type="video/mp4; codecs=hevc" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11_x180.mp4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11_x180.mp4">
                <source type="video/mp4" data-src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11_x180.mp4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/iphone11_x180.mp4">
              </video>
            </div>
            <!-- <video id="splash-illustration-top-left" class="splash-illustration-canvas"
                    autoplay loop
                     >
                    
                    <source type="video/mp4" data-src="<?php echo get_stylesheet_directory_uri(); ?>/clipdog_x180.webm" 
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/clip/dog_x180.webm">
                </video> -->
                
          </div>

        </div><!-- End Content -->
      </div>


      <!-- Additional rotating shapes -->

    </section>
    <script>
      let display_mobile_video = undefined;
      const media_query = window.matchMedia("all and (max-width: 640px)");
      media_query.addEventListener("change", setSourceForVisibleVideos);

      function setSourceForVisibleVideos(event) {
        const query_matches = event.matches;
        if (display_mobile_video !== query_matches) {
          var video_selector = ".splash-illustration-canvas";

          for (var video_element of document.querySelectorAll(video_selector)) {
            var source_changed = false;

            video_element.querySelectorAll("source").forEach(source => {
              if (source.src === "") {
                source.src = source.dataset.src
                source_changed = true;
              }
            });

            if (source_changed) {
              video_element.load();
            }
          }

          display_mobile_video = query_matches;
        }
      }

      setSourceForVisibleVideos(media_query);
    </script>
    <style>
      /*--------------------------------------------------------------
# Hero Section
--------------------------------------------------------------*/

      #splash-illustration {
        display: inline-block;
        height: 0;
        margin-left: 160px;
        position: relative;
        vertical-align: middle;
        width: calc(100% - 580px);
        z-index: 2
      }

      .splash-illustration-canvas {
        border-radius: 10px;
        box-shadow: 6px 12px 28px 1px rgba(0, 0, 0, .3);
        display: block;
        height: 308px;
        -o-object-fit: cover;
        object-fit: cover;
        outline: none;
        pointer-events: none;
        position: absolute;
        transform: rotate(3deg);
        width: 173px
      }

      #splash-illustration-top-left.splash-illustration-canvas {
        background-color: #d1ced4;
        left: 50px;
        top: 10px;

      }

      #splash-illustration-bottom-left.splash-illustration-canvas {
        background-color: #d7c5ec;
        right: 240px;
        top: 40px;
        transform: rotate(3deg);
      }

      #splash-illustration-right.splash-illustration-canvas {
        background-color: #e7e1da;
        right: 30px;
        top: -40px;
      }

      .kek-hero {
        width: 100%;
        min-height: calc(100vh - 102px);
        padding-top: 0px !important;
        margin-top: 0px !important;
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
        color: var(--kek-dark-blue);
      }

      .kek-hero .welcome p {
        font-size: 18px;
        margin: 0;
        color: var(--kek-dark-blue);
      }

      .kek-hero .content {
        margin-top: 40px;
      }

      .kek-hero .content .why-box {
        color: var(--kek-contrast-300);
        background: var(--kek-dark-blue);
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

      .kek-hero .align-items-stretch {
        align-items: stretch !important;
      }

      .kek-hero .d-flex {
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
