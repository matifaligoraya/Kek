<?php 
class WPBakeryKekVideoCard {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_video_card', array($this, 'render_kek_video_card'), 40);
    }

    public function register_elements() {
        vc_map(array(
            'name' => __('Kek Video Card', 'kek'),
            'base' => 'kek_video_card',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'heading' => __('Platform', 'kek'),
                    'param_name' => 'platform',
                    'value' => array(
                        __('Instagram', 'kek') => 'instagram',
                        __('YouTube', 'kek') => 'youtube',
                        __('TikTok', 'kek') => 'tiktok',
                    ),
                    'description' => __('Select the platform for this video card.', 'kek'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Show Floating Icons', 'kek'),
                    'param_name' => 'show_icons',
                    'value' => array(__('Yes', 'kek') => 'yes'),
                    'description' => __('Check to show floating icons on the card.', 'kek'),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Thumbnail Image', 'kek'),
                    'param_name' => 'image_url',
                    'description' => __('Upload or select a thumbnail image from the media gallery.', 'kek'),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Background Image', 'kek'),
                    'param_name' => 'background_image',
                    'description' => __('Set a background image for the video card.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Views Count', 'kek'),
                    'param_name' => 'views_count',
                    'value' => '11200',
                    'description' => __('Enter the final count of views.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Likes Count', 'kek'),
                    'param_name' => 'likes_count',
                    'value' => '2500',
                    'description' => __('Enter the final count of likes.', 'kek'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Comments Count', 'kek'),
                    'param_name' => 'comments_count',
                    'value' => '223',
                    'description' => __('Enter the final count of comments.', 'kek'),
                ),
            ),
        ));
    }

    public function render_kek_video_card($atts) {
        $atts = shortcode_atts(array(
            'platform' => 'instagram',
            'image_url' => '',
            'background_image' => '',
            'views_count' => '11200',
            'likes_count' => '2500',
            'comments_count' => '223',
            'show_icons' => 'no', // Default to showing icons
        ), $atts);
    
        $platform = esc_attr($atts['platform']);
        $image_url = !empty($atts['image_url']) ? wp_get_attachment_url($atts['image_url']) : '';
        $background_image = !empty($atts['background_image']) ? wp_get_attachment_url($atts['background_image']) : '';
    
        // Icons and colors based on platform
        $icon_color = '';
        $floating_icons = [];
        switch ($platform) {
            case 'youtube':
                $icon_color = '#FF0000'; // YouTube red
                $floating_icons = [
                    'fas fa-play', 
                    'fas fa-heart', 
                    'fas fa-comment', 
                    'fas fa-share', 
                    'fas fa-bell'
                ];
                break;
            case 'instagram':
                $icon_color = '#E1306C'; // Instagram pink
                $floating_icons = [
                    'fas fa-camera', 
                    'fas fa-heart', 
                    'fas fa-comment', 
                    'fas fa-share-alt', 
                    'fas fa-user'
                ];
                break;
            case 'tiktok':
                $icon_color = '#69C9D0'; // TikTok blue
                $floating_icons = [
                    'fas fa-music', 
                    'fas fa-heart', 
                    'fas fa-comment-alt', 
                    'fas fa-star', 
                    'fas fa-share'
                ];
                break;
        }
    
        ob_start();
        ?>
        <div class="video-card-wrapper" 
             style="background-image: url('<?php echo esc_url($background_image); ?>');
              background-size: contain;
  background-position: center;
  position: relative;
  background-repeat: no-repeat;">
             <?php if ($atts['show_icons'] === 'yes'): ?>
            <!-- Floating Icons -->
            <?php foreach ($floating_icons as $index => $icon_class): 
                        // Define ranges for icon positions to spread them properly
            $position_ranges = [
                ['top' => rand(5, 15), 'left' => rand(5, 20)], // Top-left
                ['top' => rand(5, 15), 'left' => rand(80, 95)], // Top-right
                ['top' => rand(25, 35), 'left' => rand(15, 35)], // Slightly lower-left
                ['top' => rand(25, 35), 'left' => rand(65, 85)], // Slightly lower-right
                ['top' => rand(45, 55), 'left' => rand(40, 60)], // Centered
            ];
            $position = $position_ranges[$index % count($position_ranges)];
            ?>
                <i class="icon-position dynamic-animation <?php echo $platform; ?>" 
                style="
                    --icon-top: <?php echo $position['top']; ?>%; 
                    --icon-left: <?php echo $position['left']; ?>%; 
                    --animation-name: bounce; 
                    --animation-duration: <?php echo rand(2, 5); ?>s; 
                    color: <?php echo esc_attr($icon_color); ?>;"
                   title="Icon <?php echo $index + 1; ?>">
                   <span class="<?php echo esc_attr($icon_class); ?>"></span>
                </i>
            <?php endforeach; ?>
            <?php endif; ?>
            <!-- Main Video Card -->
            <div class="video-card video-card--<?php echo $platform; ?>">
                <div class="video-card__metrics">
                    <div class="video-card__metric-cell">
                        <img decoding="async" loading="lazy" 
                             src="<?php echo esc_url($image_url); ?>" 
                             alt="Thumbnail" draggable="false">
                    </div>
                    <div class="video-card__metric-cell">
                        <i class="fas fa-eye" style="color: <?php echo esc_attr($icon_color); ?>;"></i>
                        <div class="counter"><?php echo esc_attr($atts['views_count']); ?></div>
                    </div>
                    <div class="video-card__metric-cell">
                        <i class="fas fa-heart" style="color: <?php echo esc_attr($icon_color); ?>;"></i>
                        <div class="counter"><?php echo esc_attr($atts['likes_count']); ?></div>
                    </div>
                    <div class="video-card__metric-cell">
                        <i class="fas fa-comment-alt" style="color: <?php echo esc_attr($icon_color); ?>;"></i>
                        <div class="counter"><?php echo esc_attr($atts['comments_count']); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        
        </style>
        <?php
        return ob_get_clean();
    }
    
    
    
}

// Instantiate the class
new WPBakeryKekVideoCard();
