<?php 
class SocialMediaTab extends SublimeBaseTab {

public function getTitle() {
    return __('Social Media', 'sublimeplus');
}

public function render() {
    $this->renderopen();
    ?>
    <style>
        .social-link-item select, .social-link-item input {
            float: left;
            width: 40%;
            margin: 2px 10px;
        }
        .btn.btn-primary.add-social-link {
            margin: 5px 10px;
        }
    </style>
    <div id="social-media-links" class="social-links">
        <h4><?php esc_html_e('Social Media Links', 'sublimeplus'); ?></h4>
        <button type="button" class="btn btn-primary add-social-link"><?php esc_html_e('Add New Link', 'sublimeplus'); ?></button>
        <ul class="list-unstyled">
            <?php
            $social_links = $this->getValue('social_links') ?: array('icon' => array(), 'url' => array());
            $icon_links = $social_links['icon'];
            $custom_icon_class = $social_links['custom-icon-class'];
            $url_links = $social_links['url'];
            $social_options = $this->getSocialOptions();
            
            for ($i = 0; $i < count($icon_links); $i++) :
                ?>
                <li class="social-link-item">
                    <select name="<?php echo esc_attr($this->getName('social_links')); ?>[icon][]" class="form-control">
                        <option value=""><?php esc_html_e('Select Icon', 'sublimeplus'); ?></option>
                        <?php foreach ($social_options as $label => $icon) : ?>
                            <option value="<?php echo esc_attr($icon); ?>" <?php selected($icon_links[$i], $icon); ?>>
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="<?php echo esc_attr($this->getName('social_links')); ?>[custom-icon-class][]" placeholder="Custom Icon Class" class="form-control" value="<?php echo esc_url($custom_icon_class[$i]); ?>">
                    <input type="text" name="<?php echo esc_attr($this->getName('social_links')); ?>[url][]" placeholder="URL" class="form-control" value="<?php echo esc_url($url_links[$i]); ?>">
                    <button type="button" class="btn btn-danger remove-social-link"><?php esc_html_e('Remove', 'sublimeplus'); ?></button>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.add-social-link').on('click', function() {
                var newLinkHtml = `
                    <li class="social-link-item">
                        <select name="<?php echo esc_attr($this->getName('social_links')); ?>[icon][]" class="form-control">
                            <option value=""><?php esc_html_e('Select Icon', 'sublimeplus'); ?></option>
                            <?php foreach ($social_options as $label => $icon) : ?>
                                <option value="<?php echo esc_attr($icon); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="<?php echo esc_attr($this->getName('social_links')); ?>[custom-icon-class][]" placeholder="Custom Icon Class" class="form-control">
                        <input type="text" name="<?php echo esc_attr($this->getName('social_links')); ?>[url][]" placeholder="URL" class="form-control">
                        <button type="button" class="btn btn-danger remove-social-link"><?php esc_html_e('Remove', 'sublimeplus'); ?></button>
                    </li>`;
                $('#social-media-links ul').append(newLinkHtml);
            });

            $(document).on('click', '.remove-social-link', function() {
                $(this).closest('.social-link-item').remove();
            });
        });
    </script>
    <?php
    $this->renderclose();
}

public function renderopen() {
    echo '<div class="tab-pane" id="social-settings" role="tabpanel" aria-labelledby="social-settings_">';
    echo '<div class="bd-example bg-light p-3 f-18 border">';
    echo '<caption>' . esc_html($this->getTitle() . ' Options', 'sublimeplus') . '</caption>';
    echo '</div><div class="highlight pan">';
}

public function renderclose() {
    echo '</div></div>';
}

public function sanitize($inputs) {
    $sanitized_inputs = array();
    if (isset($inputs['social_links'])) {
        foreach ($inputs['social_links']['icon'] as $index => $icon) {
            $sanitized_inputs['social_links']['icon'][$index] = sanitize_text_field($icon);
            $sanitized_inputs['social_links']['url'][$index] = esc_url_raw($inputs['social_links']['url'][$index]);
        }
    }
    return $sanitized_inputs;
}

private function getSocialOptions() {
    return array(
        'Facebook' => 'fab fa-facebook-f',
        'Twitter' => 'fab fa-twitter',
        'Instagram' => 'fab fa-instagram',
        'LinkedIn' => 'fab fa-linkedin-in',
        'YouTube' => 'fab fa-youtube',
        'Pinterest' => 'fab fa-pinterest',
        'Snapchat' => 'fab fa-snapchat-ghost',
        'Reddit' => 'fab fa-reddit-alien',
        'Tumblr' => 'fab fa-tumblr',
        'WhatsApp' => 'fab fa-whatsapp',
        'TikTok' => 'fab fa-tiktok',
        'GitHub' => 'fab fa-github',
        'Vimeo' => 'fab fa-vimeo-v',
        'Dribbble' => 'fab fa-dribbble',
        'Behance' => 'fab fa-behance',
        'Flickr' => 'fab fa-flickr',
        'Medium' => 'fab fa-medium-m',
        'Quora' => 'fab fa-quora',
        'Telegram' => 'fab fa-telegram-plane',
        'Discord' => 'fab fa-discord',
        'Spotify' => 'fab fa-spotify',
        'SoundCloud' => 'fab fa-soundcloud',
        'Twitch' => 'fab fa-twitch',
        'Slack' => 'fab fa-slack',
        'Weibo' => 'fab fa-weibo',
        'VK' => 'fab fa-vk',
        'WeChat' => 'fab fa-weixin',
    );
}
}
