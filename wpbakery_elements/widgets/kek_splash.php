<?php
class WPBakeryKekSplashElement {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_splash', array($this, 'render_kek_splash'), 40);
    }

    public function register_elements() {
        // Register the Splash Element
        vc_map(array(
            'name' => __('Kek Splash', 'kek'),
            'base' => 'kek_splash',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'attach_image',
                    'heading' => __('Splash Background Image', 'kek'),
                    'param_name' => 'splash_bg',
                    'description' => __('Upload the background image for the Splash.', 'kek'),
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

    public function render_kek_splash($atts) {
        $atts = shortcode_atts(array(
            'splash_bg' => '',
            'welcome_title' => 'WELCOME',
            'welcome_desc' => 'We are a team of talented designers making websites with Bootstrap.',
            'why_title' => 'Why Choose Us?',
            'why_desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            'content_boxes' => '',
        ), $atts);

        // Get Splash Background Image
        $splash_bg_url = $atts['splash_bg'] ? wp_get_attachment_image_url($atts['splash_bg'], 'full') : '';

        // Parse Content Boxes
        $content_boxes = vc_param_group_parse_atts($atts['content_boxes']);

        ob_start();
        ?>
     <section id="splash" class="container">
  
        <video id="splash-video-background" class="splash-illustration-canvas configured" poster="/img/videos/tt_dance_x640.webp" disableremoteplayback="" preload="" tabindex="-1" loop="" muted="true" playsinline="">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x320.webm" media="all and (max-width: 320px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x360.webm" media="all and (max-width: 360px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x380.webm" media="all and (max-width: 380px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x420.webm" media="all and (max-width: 420px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x480.webm" media="all and (max-width: 480px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x500.webm" media="all and (max-width: 500px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x560.webm" media="all and (max-width: 560px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x600.webm" media="all and (max-width: 600px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x640.webm" media="all and (max-width: 640px)">
            <source type="video/webm" data-src="/img/videos/webm/tt_dance_x720.webm" media="all and (max-width: 720px)">

            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x320.mp4" media="all and (max-width: 320px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x360.mp4" media="all and (max-width: 360px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x380.mp4" media="all and (max-width: 380px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x420.mp4" media="all and (max-width: 420px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x480.mp4" media="all and (max-width: 480px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x500.mp4" media="all and (max-width: 500px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x560.mp4" media="all and (max-width: 560px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x600.mp4" media="all and (max-width: 600px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x640.mp4" media="all and (max-width: 640px)">
            <source type="video/mp4; codecs=hevc" data-src="/img/videos/hevc/tt_dance_x720.mp4" media="all and (max-width: 720px)">

            <source type="video/mp4" data-src="/img/videos/tt_dance_x320.mp4" media="all and (max-width: 320px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x360.mp4" media="all and (max-width: 360px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x380.mp4" media="all and (max-width: 380px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x420.mp4" media="all and (max-width: 420px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x480.mp4" media="all and (max-width: 480px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x500.mp4" media="all and (max-width: 500px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x560.mp4" media="all and (max-width: 560px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x600.mp4" media="all and (max-width: 600px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x640.mp4" media="all and (max-width: 640px)">
            <source type="video/mp4" data-src="/img/videos/tt_dance_x720.mp4" media="all and (max-width: 720px)">
        </video>
        <div id="splash-content" class="row">
            <div id="splash-text" class="col">
                <h1>Purchase TikTok followers, likes and views</h1>
                <p>Celebian is a top-rated TikTok growth platform for a good reason. Explore the quality services we offer below.</p>
                <div class="splash-trustpilot">
                    <img src="/img/illustrations/trustpilot-5-stars.svg" alt="Trustpilot - 5 stars" draggable="false" width="160" height="30">
                    <p>4.7 | Rated Excellent on Trustpilot</p>
                </div>
                <div class="button text-pink black-shadow to-all-services" data-button-analytics-id="See all services - Landing">See all services</div>
                <img fetchpriority="high" class="splash__title-scribbles" src="/img/illustrations/landing-title__scribbles--white.webp" alt="Scribbles with exclamations">
                <img fetchpriority="high" class="splash__button-scribbles" src="/img/illustrations/landing-button__scribbles--white.webp" alt="An arrow pointing down with a smiley face">
            </div>
            <div id="splash-illustration" class="col">
                <video id="splash-illustration-top-left" class="splash-illustration-canvas video-element--loaded" poster="/img/splash/dog.webp" disableremoteplayback="" preload="metadata" tabindex="-1" loop="" muted="true" playsinline="">
                    <source type="video/webm" data-src="/img/splash/webm/dog_x180.webm" src="/img/splash/webm/dog_x180.webm">
                    <source type="video/mp4; codecs=hevc" data-src="/img/splash/hevc/dog_x180.mp4" src="/img/splash/hevc/dog_x180.mp4">
                    <source type="video/mp4" data-src="/img/splash/dog_x180.mp4" src="/img/splash/dog_x180.mp4">
                </video>
                <video id="splash-illustration-bottom-left" class="splash-illustration-canvas video-element--loaded" poster="/img/splash/parisoslo.webp" disableremoteplayback="" preload="metadata" tabindex="-1" loop="" muted="true" playsinline="">
                    <source type="video/webm" data-src="/img/splash/webm/parisoslo_x180.webm" src="/img/splash/webm/parisoslo_x180.webm">
                    <source type="video/mp4; codecs=hevc" data-src="/img/splash/hevc/parisoslo_x180.mp4" src="/img/splash/hevc/parisoslo_x180.mp4">
                    <source type="video/mp4" data-src="/img/splash/parisoslo_x180.mp4" src="/img/splash/parisoslo_x180.mp4">
                </video>
                <video id="splash-illustration-right" class="splash-illustration-canvas video-element--loaded" poster="/img/splash/iphone11.webp" disableremoteplayback="" preload="metadata" tabindex="-1" loop="" muted="true" playsinline="">
                    <source type="video/webm" data-src="/img/splash/webm/iphone11_x180.webm" src="/img/splash/webm/iphone11_x180.webm">
                    <source type="video/mp4; codecs=hevc" data-src="/img/splash/hevc/iphone11_x180.mp4" src="/img/splash/hevc/iphone11_x180.mp4">
                    <source type="video/mp4" data-src="/img/splash/iphone11_x180.mp4" src="/img/splash/iphone11_x180.mp4">
                </video>
            </div>
           
        </div>
    </section>
        <style>
      
#splash:after {
  content:"";
  height:100%;
  min-height:100vh;
  width:0
}
#splash #splash-content,
#splash:after {
  display:inline-block;
  vertical-align:middle
}
#splash #splash-content {

  padding:120px 4%;
  position:relative;
  text-align:left;
 
  z-index:1
}
#splash #splash-content #splash-text {
  display:inline-block;
  position:relative;
  text-align:left;
  vertical-align:middle;
  width:420px
}
#splash #splash-content #splash-text h1 {
  max-width:450px;
  padding-bottom:20px
}
#splash #splash-content #splash-text .button {
  margin-top:20px;
  z-index:2
}
#splash #splash-content .splash__title-scribbles {
  left:137px;
  top:-97px;
  width:382px
}
#splash #splash-content .splash__button-scribbles,
#splash #splash-content .splash__title-scribbles {
  opacity:.3;
  pointer-events:none;
  position:absolute;
  -webkit-user-select:none;
  -moz-user-select:none;
  user-select:none;
  z-index:1
}
#splash #splash-content .splash__button-scribbles {
  bottom:-80px;
  left:229px;
  transform:rotate(10deg);
  width:114px
}
#splash #splash-content .splash-trustpilot {
  background:hsla(0,0%,100%,.08);
  border:1px solid hsla(0,0%,100%,.4);
  border-radius:6px;
  margin-top:15px;
  padding:20px 15px 13px
}
#splash #splash-content .splash-trustpilot img {
  height:30px
}
#splash #splash-content .splash-trustpilot p {
  font-size:16px;
  margin-top:10px
}
#splash #splash-content #splash-illustration {
  display:inline-block;
  height:0;
  margin-left:160px;
  position:relative;
  vertical-align:middle;
  width:calc(100% - 580px);
  z-index:2
}
#splash #splash-content #splash-illustration .splash-illustration-canvas {
  border-radius:10px;
  box-shadow:6px 12px 28px 1px rgba(0,0,0,.3);
  display:block;
  height:308px;
  -o-object-fit:cover;
  object-fit:cover;
  outline:none;
  pointer-events:none;
  position:absolute;
  transform:rotate(3deg);
  width:173px
}
#splash #splash-content #splash-illustration .splash-illustration-canvas.video-element--loaded {
  background-color:transparent!important
}
#splash #splash-content #splash-illustration #top-left.splash-illustration-canvas {
  left:0;
  top:-323px
}
#splash #splash-content #splash-illustration #bottom-left.splash-illustration-canvas {
  left:0;
  top:15px
}
#splash #splash-content #splash-illustration #right.splash-illustration-canvas {
  left:210px;
  top:-154px
}
#splash #splash-content #splash-illustration #splash-illustration-top-left.splash-illustration-canvas {
  background-color:#d1ced4;
  left:0;
  top:-323px
}
#splash #splash-content #splash-illustration #splash-illustration-bottom-left.splash-illustration-canvas {
  background-color:#d7c5ec;
  left:-18px;
  top:15px
}
#splash #splash-content #splash-illustration #splash-illustration-right.splash-illustration-canvas {
  background-color:#e7e1da;
  left:200px;
  top:-154px
}
#splash #splash-background .figure {
  left:calc(50% - 600px);
  position:absolute;
  top:calc(50% - 280px);
  width:1200px
}

#splash #splash-video-background {
  background:#bf0970;
  display:none;
  left:0;
  pointer-events:none;
  position:absolute;
  top:0;
  z-index:1
}
#splash #splash-video-background.configured {
  display:none
}

            </style>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekSplashElement();
