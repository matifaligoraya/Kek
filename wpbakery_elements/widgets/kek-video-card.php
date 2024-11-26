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
                    'type' => 'attach_image',
                    'heading' => __('Thumbnail Image', 'kek'),
                    'param_name' => 'image_url',
                    'description' => __('Upload or select a thumbnail image from the media gallery.', 'kek'),
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
            'views_count' => '11200',
            'likes_count' => '2500',
            'comments_count' => '223',
        ), $atts);

        $platform = esc_attr($atts['platform']);
        $image_url = !empty($atts['image_url']) ? wp_get_attachment_url($atts['image_url']) : '/img/illustrations/comedy-post.webp';
        $views_count = esc_attr($atts['views_count']);
        $likes_count = esc_attr($atts['likes_count']);
        $comments_count = esc_attr($atts['comments_count']);

        // Icons and colors based on platform
        $icon_color = '';
        $view_icon = $like_icon = $comment_icon = '';
        switch ($platform) {
            case 'youtube':
                $icon_color = '#FF0000'; // YouTube red
                $view_icon = 'fas fa-eye';
                $like_icon = 'fas fa-thumbs-up';
                $comment_icon = 'fas fa-comments';
                break;
            case 'instagram':
                $icon_color = '#E1306C'; // Instagram pink
                $view_icon = 'fas fa-video';
                $like_icon = 'fas fa-heart';
                $comment_icon = 'fas fa-comment';
                break;
            case 'tiktok':
                $icon_color = '#69C9D0'; // TikTok blue
                $view_icon = 'fas fa-music';
                $like_icon = 'fas fa-star';
                $comment_icon = 'fas fa-comment-alt';
                break;
        }

        ob_start();
        ?>
        <div class="video-card video-card--<?php echo $platform; ?>">
           
            <div class="video-card__metrics">
            <div class="video-card__metric-cell" >
            <img loading="lazy" src="<?php echo esc_url($image_url); ?>" alt=" " draggable="false">
                </div>
                <div class="video-card__metric-cell" >
                    <i class="<?php echo $view_icon; ?>"  style="color: <?php echo esc_attr($icon_color); ?>;"></i>
                    <div class="counter">
                        <span data-from="0" 
                              data-to="<?php echo $views_count; ?>" 
                              data-refresh-interval="20" 
                              data-speed="2000">
                              <?php echo $views_count; ?>
                        </span>
                    </div>
                </div>
                <div class="video-card__metric-cell">
                    <i class="<?php echo $like_icon; ?>"  style="color: <?php echo esc_attr($icon_color); ?>;"></i>
                    <div class="counter">
                        <span data-from="0" 
                              data-to="<?php echo $likes_count; ?>" 
                              data-refresh-interval="20" 
                              data-speed="2000">
                              <?php echo $likes_count; ?>
                        </span>
                    </div>
                </div>
                <div class="video-card__metric-cell" >
                    <i class="<?php echo $comment_icon; ?>" style="color: <?php echo esc_attr($icon_color); ?>;"></i>
                    <div class="counter">
                        <span data-from="0" 
                              data-to="<?php echo $comments_count; ?>" 
                              data-refresh-interval="20" 
                              data-speed="2000">
                              <?php echo $comments_count; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
         <style>
           
.video-card {
  align-items: center;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0px 1px 8px 0px rgba(0, 0, 0, 0.4);
  display: flex;
  flex-direction: column;

  padding: 12px;
  width: 400px;
  transition: all 0.7s ease-out;
  animation: float 6s ease-in-out infinite;
}
.video-card__metric-cell i{
    font-size: 24px;
}
.video-card__metric-cell .counter {
  
  font-size: 16px ;
  font-weight: normal;
}
.video-card__metrics > img {
  border-radius: 6px;
  flex-shrink: 0;
  height: 80px;
  width: 80px;
}

.video-card__metrics {
  align-items: center;
  display: flex;
  flex-direction: row;
  flex-grow: 1;
  justify-content: center;
  padding-top: 3px;
}

.video-card__metric-cell {
    align-items: center;
  border-right: 1px solid #eee;
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 100px;
}

.video-card__metric-cell:last-child {
  border-right: 0;
}
.video-card__metric-cell p {
  font-size: inherit;
  padding-top: 5px;
}


        </style>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKekVideoCard();
