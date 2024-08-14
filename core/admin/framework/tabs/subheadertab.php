<?php 
class SubHeaderTab extends SublimeBaseTab {
    public function getTitle() {
        return __('Sub Header', 'sublimeplus');
    }

    public function render() {
        $this->renderopen();
        ?>
        <style>
            .sub-header-tile-item {
                padding-top: 10px !important;
            }
        </style>
        <div id="sub-header-tiles" class="sub-header-tiles">
            <h4><?php esc_html_e('Sub Header Tiles', 'sublimeplus'); ?></h4>
            <button type="button" class="btn btn-primary add-sub-header-tile"><?php esc_html_e('Add New Subheader Tile', 'sublimeplus'); ?></button>
            <ul class="list-unstyled">
                <?php
                $sub_header_tiles = $this->getValue('sub_header_tiles') ?: 
                                    array(
                                        'image' => array(),
                                        'title' => array(),
                                        'isNew' => array(),
                                        'menu' => array()
                                    );                                                

                $menus = wp_get_nav_menus();

                for ($i = 0; $i < count($sub_header_tiles['title']); $i++) :
                    ?>
                    <li class="sub-header-tile-item">
                        <div class="sub-header-tile-input-div">  
                            <div class="row">
                                <div class="col-md-3">                                    
                                    <input type="text" name="<?php echo esc_attr($this->getName('sub_header_tiles')); ?>[title][]" placeholder="Title" class="form-control" value="<?php echo esc_attr($sub_header_tiles['title'][$i]); ?>">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="<?php echo esc_js($this->getName('sub_header_tiles')); ?>[image][]" class="form-control image-url" value="<?php echo esc_url($sub_header_tiles['image'][$i]); ?>" readonly>                                    
                                    <br />
                                    <img src="<?php echo esc_url($sub_header_tiles['image'][$i]); ?>" width="100" height="100" />                                    
                                    <button type="button" class="button-secondary upload-image-button"><?php esc_html_e('Upload Image', 'sublimeplus'); ?></button>
                                </div>

                                <div class="col-md-3">
                                    <label><input type="checkbox" name="<?php echo esc_attr($this->getName('sub_header_tiles')); ?>[isNew][]" value="1" <?php checked($sub_header_tiles['isNew'][$i], 1); ?>> <?php esc_html_e('Is New', 'sublimeplus'); ?></label>
                                </div>

                                <div class="col-md-3">
                                    <select name="<?php echo esc_attr($this->getName('sub_header_tiles')); ?>[menu][]" class="form-control">
                                        <option value=""><?php esc_html_e('Select Menu', 'sublimeplus'); ?></option>
                                        <?php foreach ($menus as $menu) : ?>
                                            <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($sub_header_tiles['menu'][$i], $menu->term_id); ?>><?php echo esc_html($menu->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>                                                                                
                        </div>

                        <button type="button" class="btn btn-danger mt-2 remove-sub-header-tile">
                            <?php esc_html_e('Remove', 'sublimeplus'); ?>
                        </button>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('.add-sub-header-tile').on('click', function() {
                    var newLinkHtml = `
                        <li class="sub-header-tile-item">
                            <div class="row">
                                <div class="col-md-3">                                    
                                    <input type="text" name="<?php echo esc_js($this->getName('sub_header_tiles')); ?>[title][]" placeholder="Title" class="form-control">                                    
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="<?php echo esc_js($this->getName('sub_header_tiles')); ?>[image][]" class="form-control image-url" readonly>
                                    <button type="button" class="button-secondary upload-image-button"><?php esc_html_e('Upload Image', 'sublimeplus'); ?></button>
                                </div>
                                <div class="col-md-3">
                                    <select name="<?php echo esc_attr($this->getName('sub_header_tiles')); ?>[menu][]" class="form-control">
                                        <option value=""><?php esc_html_e('Select Menu', 'sublimeplus'); ?></option>
                                        <?php foreach ($menus as $menu) : ?>
                                            <option value="<?php echo esc_attr($menu->term_id); ?>"><?php echo esc_html($menu->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>
                                        <input type="checkbox" name="<?php echo esc_js($this->getName('sub_header_tiles')); ?>[isNew][]" value="1"> <?php esc_html_e('Is New', 'sublimeplus'); ?>
                                    </label>
                                </div>                                
                            </div>
                            
                            <button type="button" class="btn btn-danger mt-2 remove-sub-header-tile"><?php esc_html_e('Remove', 'sublimeplus'); ?></button>
                        </li>`;
                    $('#sub-header-tiles ul').append(newLinkHtml);
                });

                $(document).on('click', '.remove-sub-header-tile', function() {
                    $(this).closest('.sub-header-tile-item').remove();
                });

                $(document).on('click', '.upload-image-button', function(e) {
                    e.preventDefault();                    
                    var button = $(this);
                    var image = wp.media({
                        title: 'Upload Image',
                        multiple: false
                    }).open().on('select', function() {
                        var uploaded_image = image.state().get('selection').first();
                        var image_url = uploaded_image.toJSON().url;
                        // Update the input field with the new image URL
                        button.siblings('.image-url').val(image_url); 
                        // Update the image preview
                        button.siblings('img').attr('src', image_url);
                    });
                });
            });
        </script>
        <?php
        $this->renderclose();
    }

    public function renderopen() {
        echo '<div class="tab-pane" id="sub-header-settings" role="tabpanel" aria-labelledby="sub-header-settings_">';
        echo '<div class="bd-example bg-light p-3 f-18 border">';
        echo '<caption>' . esc_html($this->getTitle() . ' Options', 'sublimeplus') . '</caption>';
        echo '</div><div class="highlight pan">';
    }

    public function renderclose() {
        echo '</div></div>';
    }

    public function sanitize($inputs) {
        $sanitized_inputs = array();
        if (isset($inputs['sub_header_tiles'])) {
            foreach ($inputs['sub_header_tiles']['title'] as $index => $title) {
                $sanitized_inputs['sub_header_tiles']['title'][$index] = sanitize_text_field($title);
                $sanitized_inputs['sub_header_tiles']['isNew'][$index] = isset($inputs['sub_header_tiles']['isNew'][$index]) ? 1 : 0;
                $sanitized_inputs['sub_header_tiles']['menu'][$index] = absint($inputs['sub_header_tiles']['menu'][$index]);                            

                // Check if image URL is provided, if not, use an empty string
                $sanitized_inputs['sub_header_tiles']['image'][$index] = isset($inputs['sub_header_tiles']['image'][$index]) ? esc_url($inputs['sub_header_tiles']['image'][$index]) : '';
    
                if (!empty($_FILES[$this->getName('sub_header_tiles')]['name']['image'][$index])) {
                    $uploadedfile = array(
                        'name' => $_FILES[$this->getName('sub_header_tiles')]['name']['image'][$index],
                        'type' => $_FILES[$this->getName('sub_header_tiles')]['type']['image'][$index],
                        'tmp_name' => $_FILES[$this->getName('sub_header_tiles')]['tmp_name']['image'][$index],
                        'error' => $_FILES[$this->getName('sub_header_tiles')]['error']['image'][$index],
                        'size' => $_FILES[$this->getName('sub_header_tiles')]['size']['image'][$index],
                    );
    
                    $upload_overrides = array('test_form' => false);
    
                    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
    
                    if ($movefile && !isset($movefile['error'])) {
                        $attachment_id = $this->insert_attachment($movefile['file']);
                        $sanitized_inputs['sub_header_tiles']['image'][$index] = wp_get_attachment_url($attachment_id);
                    }
                }
            }
        }
        return $sanitized_inputs;
    }    
        
    private function insert_attachment($file_path) {
        $filetype = wp_check_filetype(basename($file_path), null);
        $wp_upload_dir = wp_upload_dir();
    
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($file_path),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_path)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
    
        $attachment_id = wp_insert_attachment($attachment, $file_path);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attachment_id, $file_path);
        wp_update_attachment_metadata($attachment_id, $attach_data);
    
        return $attachment_id;
    }
}
