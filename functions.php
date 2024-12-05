<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
//define('kek_DIR', wp_normalize_path(get_template_directory() . '/'));
require get_template_directory() . '/core/const.php';
$picostrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/clean-head.php',							// Eliminates useless meta tags, emojis, etc            
	'/enqueues.php', 							// Enqueue scripts and styles.     
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	//'/hooks.php',                           // Custom hooks.
	//'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/custom-comments.php',                 // Custom Comments file.
	//'/jetpack.php',                         // Load Jetpack compatibility file.
	'/bootstrap-navwalker.php',    			// Load custom WordPress nav walker. 
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions. 
	'/customizer-assets/customizer.php',	//Defines Customizer options
	'/picosass-compiler-integration.php',	//To interface the Customizer with the SCSS js compiler
	//'/scssphp-legacy-compiler-integration.php', //To interface the Customizer with the SCSS php compiler
	'/options-page.php',                  // Load theme options page. 
	'/content-filtering.php',				//for LC compatibility when shutting down plugin

);

foreach ( $picostrap_includes as $file ) {
	require_once get_template_directory() . '/inc' . $file;
}

//PURELY OPT-IN FEATURES ////////////////

//OPTIONAL: DISABLE WORDPRESS COMMENTS
if (get_theme_mod("singlepost_disable_comments") ) require_once locate_template('/inc/opt-in/disable-comments.php'); 

//OPTIONAL: BACK TO TOP
if (get_theme_mod("enable_back_to_top") ) require_once locate_template('/inc/opt-in/back-to-top.php');

//OPTIONAL: LIGHTBOX  
if (get_theme_mod("enable_lightbox") ) require_once locate_template('/inc/opt-in/lightbox.php');
	
//OPTIONAL: TOOLTIPS  
if (get_theme_mod("enable_tooltips") ) require_once locate_template('/inc/opt-in/initialize-tooltips.php');
	
//OPTIONAL: DETECT PAGE SCROLL
if (get_theme_mod("enable_detect_page_scroll") ) require_once locate_template('/inc/opt-in/detect-page-scroll.php');

//OPTIONAL: DISABLE GUTENBERG  
if (get_theme_mod("disable_gutenberg") ) require_once locate_template('/inc/opt-in/disable-gutenberg.php');
	
//OPTIONAL: DISABLE WIDGETS BLOCK EDITOR  
if (get_theme_mod("disable_widgets_block_editor") ) require_once locate_template('/inc/opt-in/disable-widgets-block-editor.php');
	
//OPTIONAL: DISABLE XML/RPC
if (get_theme_mod("disable_xml_rpc") ) require_once locate_template('/inc/opt-in/disable-xml-rpc.php');
	
add_action('vc_before_init', 'kek_load_wpbakery_elements');

function kek_load_wpbakery_elements() {    
	$vcDirectoryPath = kek_DIR . '/wpbakery_elements/widgets/*.php';

	// Use glob() to get an array of file names
	$vcFiles = glob($vcDirectoryPath);

	// Check if there are any files
	if ($vcFiles !== false) {
		// Loop through the array of file names
		foreach ($vcFiles as $vcFile) {
			// Include each file
			require_once($vcFile);
		}
	}
}

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', array(), '6.5.0');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');


function add_product_feature_meta_box() {
    add_meta_box(
        'product_feature_meta_box',
        __('Product Features', 'kek'),
        'render_product_feature_meta_box',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_product_feature_meta_box');

function render_product_feature_meta_box($post) {
    $product_features = get_post_meta($post->ID, '_product_features', true) ?: [];
	$platform = get_post_meta($post->ID, '_product_platform', true) ?: '';
    $type = get_post_meta($post->ID, '_product_type', true) ?: '';

    wp_nonce_field('save_product_features', 'product_features_nonce');
    ?>
	 <div>
        <label for="product_platform">Platform:</label>
        <input type="text" id="product_platform" name="product_platform" value="<?php echo esc_attr($platform); ?>" placeholder="Platform (e.g., Instagram)" />
    </div>
    <div>
        <label for="product_type">Type:</label>
        <input type="text" id="product_type" name="product_type" value="<?php echo esc_attr($type); ?>" placeholder="Type (e.g., Design)" />
    </div>
    <hr />
    <div id="product-feature-list">
        <?php foreach ($product_features as $index => $feature): ?>
            <div class="feature-item">
                <input type="text" name="product_features[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($feature['icon']); ?>" placeholder="Icon class (e.g., fa fa-star)" />
                <input type="text" name="product_features[<?php echo $index; ?>][text]" value="<?php echo esc_attr($feature['text']); ?>" placeholder="Feature text" />
                <button type="button" class="remove-feature">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-feature">Add Feature</button>
    <script>
        document.getElementById('add-feature').addEventListener('click', function () {
            const container = document.getElementById('product-feature-list');
            const index = container.children.length;
            const item = document.createElement('div');
            item.className = 'feature-item';
            item.innerHTML = `
                <input type="text" name="product_features[${index}][icon]" placeholder="Icon class (e.g., fa fa-star)" />
                <input type="text" name="product_features[${index}][text]" placeholder="Feature text" />
                <button type="button" class="remove-feature">Remove</button>
            `;
            item.querySelector('.remove-feature').addEventListener('click', () => item.remove());
            container.appendChild(item);
        });
        document.querySelectorAll('.remove-feature').forEach(button => button.addEventListener('click', function () {
            this.parentElement.remove();
        }));
    </script>
    <style>
        .feature-item {
            margin-bottom: 10px;
        }
        .feature-item input {
            margin-right: 10px;
        }
        .remove-feature {
            color: red;
            cursor: pointer;
        }
    </style>
    <?php
}


function save_product_features($post_id) {
    if (!isset($_POST['product_features_nonce']) || !wp_verify_nonce($_POST['product_features_nonce'], 'save_product_features')) {
        return;
    }

    $features = $_POST['product_features'] ?? [];
    update_post_meta($post_id, '_product_features', array_values($features));

	 // Save Platform
	 $platform = isset($_POST['product_platform']) ? sanitize_text_field($_POST['product_platform']) : '';
	 update_post_meta($post_id, '_product_platform', $platform);
 
	 // Save Type
	 $type = isset($_POST['product_type']) ? sanitize_text_field($_POST['product_type']) : '';
	 update_post_meta($post_id, '_product_type', $type);
}
add_action('save_post', 'save_product_features');



/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function starter_get_svg( $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return __( 'Please define default parameters in the form of an array.', 'starter' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return __( 'Please define an SVG icon filename.', 'starter' );
	}

	// Set defaults.
	$defaults = array(
		'icon'     => '',
		'title'    => '',
		'desc'     => '',
		'fallback' => false,
		'class'    => '',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * starter doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
	 *
	 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
	 *
	 * Example 1 with title: <?php starter_get_svg( array( 'icon' => 'arrow-up', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
	 *
	 * Example 2 with title and description: <?php starter_get_svg( array( 'icon' => 'arrow-up', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
	 *
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = starter_unique_id();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg class="icon-' . esc_attr( $args['icon'] ) . ' ' . esc_attr( $args['class'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use href="#' . esc_html( $args['icon'] ) . '" xlink:href="#' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}

add_action( 'init', 'remove_woocommerce_product_images' );
function remove_woocommerce_product_images() {
    // Remove product images and sale badges
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
}

// Wrap main content with Bootstrap layout
add_action( 'woocommerce_before_main_content', 'custom_product_page_layout_start', 5 );
add_action( 'woocommerce_after_main_content', 'custom_product_page_layout_end', 15 );

function custom_product_page_layout_start() {
    echo '<div class="content_wrapper pt-5 pb-5"><div class="container"><div class="row">';
}

function custom_product_page_layout_end() {
    echo '</div></div></div>';
}

// Add custom layout for product page
add_action( 'woocommerce_before_single_product_summary', 'custom_product_page_left_start', 5 );
add_action( 'woocommerce_after_single_product_summary', 'custom_product_page_left_end', 5 );

function custom_product_page_left_start() {
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<div class="product-left">';
}

function custom_product_page_left_end() {
    echo '</div></div>'; // Close left column
    echo '<div class="col-md-6">';
    echo '<div class="product-right">';
	custom_product_features();
    echo '</div></div>'; // Close right column
    echo '</div>'; // Close row
}

// Add product features to the left column under the title
//add_action( 'woocommerce_single_product_summary', 'custom_product_features', 20 );

function custom_product_features() {
    global $product;
    $features = get_post_meta($product->get_id(), '_product_features', true);
	$platform = get_post_meta($product->get_id(), '_product_platform', true) ?: '';
    $type = get_post_meta($product->get_id(), '_product_type', true) ?: '';
    if (!empty($features)): ?>
	<div class="sublime-custom <?php echo $platform; ?> <?php echo $type; ?>">
        <div class="product-features sublimegrid">
            <?php foreach ($features as $index => $feature): ?>
                <div class="sublimecard <?php echo ($index % 3 == 0) ? 'wide' : (($index % 2 == 0) ? 'tall' : 'wide'); ?>">
				<div class="feature-icon">
                        <i class="<?php echo esc_attr($feature['icon']); ?>"></i>
                    </div>
                    <div class="feature-text">
                        <p><?php echo esc_html($feature['text']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
		</div>
    <?php endif;
}


// Move tabs and related products to a new row below
add_action( 'woocommerce_after_single_product', 'custom_product_page_additional_content', 30 );

function custom_product_page_additional_content() {
    echo '<div class="row mt-5"><div class="col-12">';
    // You can enable these when needed:
    // woocommerce_output_product_data_tabs();
    // woocommerce_output_related_products();
    echo '</div></div>';
}



add_filter('woocommerce_product_tabs', 'remove_reviews_and_additional_information_tabs', 98);

function remove_reviews_and_additional_information_tabs($tabs) {
    // Remove the Reviews tab
    if (isset($tabs['reviews'])) {
        unset($tabs['reviews']);
    }

    // Remove the Additional Information tab
    if (isset($tabs['additional_information'])) {
        unset($tabs['additional_information']);
    }

    return $tabs;
}

add_action('init', 'remove_product_meta_section');

function remove_product_meta_section() {
    // Remove the product meta section (SKU, Categories, Tags)
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

}

add_action('woocommerce_after_single_product_summary', 'custom_add_to_cart_row', 5);


function custom_add_to_cart_row() {
    global $product;
    $platform = get_post_meta($product->get_id(), '_product_platform', true) ?: '';
    $type = get_post_meta($product->get_id(), '_product_type', true) ?: '';

    echo '<div class="add-to-cart-row ' . esc_attr($platform) . ' ' . esc_attr($type) . '" style="padding-top: 45px !important;text-align: center;">';

    if ($product->is_type('variable')) {
        // Get variation attributes and available variations
        $attributes = $product->get_variation_attributes();
        $available_variations = $product->get_available_variations();
    
        // Render variations as Bootstrap radio buttons
        foreach ($attributes as $attribute_name => $options) {
            $attribute_label = wc_attribute_label($attribute_name);
            $attribute_name_cleaned = sanitize_title($attribute_name);
    
            echo '<div class="container mb-4">';
            echo '<h3>' . esc_html($attribute_label) . '</h3>';
            echo '<div class="btn-group" role="group" aria-label="' . esc_attr($attribute_label) . '">';
    
            foreach ($options as $option_value) {
                // Find the matching variation for this option
                $matching_variation = array_filter($available_variations, function ($variation) use ($attribute_name_cleaned, $option_value) {
                    return isset($variation['attributes']['attribute_' . $attribute_name_cleaned]) && $variation['attributes']['attribute_' . $attribute_name_cleaned] === $option_value;
                });
    
                if (!empty($matching_variation)) {
                    $variation = reset($matching_variation); // Get the first matching variation
                    $price = wc_price($variation['display_price']);
                    $regular_price = wc_price($variation['display_regular_price']);
                    $is_on_sale = $variation['display_regular_price'] > $variation['display_price'];
    
                    $price_label = $is_on_sale
                        ? '<del class="me-1">' . $regular_price . '</del>' . $price
                        : $price;
    
                    // Render the Bootstrap radio button
                    echo '<input type="radio" class="btn-check variation-radio" name="selected_variation_' . esc_attr($attribute_name_cleaned) . '" id="' . esc_attr(sanitize_title($option_value)) . '" value="' . esc_attr($option_value) . '" autocomplete="off">';
                    echo '<label class="btn btn-outline-primary" for="' . esc_attr(sanitize_title($option_value)) . '">';
                    echo '<span>' . esc_html($option_value) . ' </span> <span>' . $price_label . '</span>';
                    echo '</label>';
                }
            }
    
            echo '</div>';
            echo '</div>';
        }
    }
    

    echo '</div>';

	echo '<div class="add-to-cart-row ' . esc_attr($platform) . ' ' . esc_attr($type) . '" style="padding-top: 45px !important;text-align: center;">';
 // Add the sign-up button (initially disabled)
 $redirect_url = 'https://panel.buyyoutubviews.com/signup'; // The URL to redirect to
 echo '<a href="' . esc_url($redirect_url) . '" class="button custom-redirect-button" disabled>' . __('Sign Up Now', 'woocommerce') . '</a>';
 echo '</div>';

 echo "<script>
 jQuery(document).ready(function ($) {
     // Get the Sign Up button
     const signUpButton = $('.custom-redirect-button');
     signUpButton.attr('disabled', 'disabled');
     signUpButton.attr('aria-disabled', 'true');

     // Add event listener to variation radio buttons
     $('input.variation-radio').on('change', function () {
         const selected = $('input.variation-radio:checked').val();

         // Update styles and enable/disable the button based on selection
         $('.variable-item').removeClass('selected');
         $(this).closest('.variable-item').addClass('selected');

         if (selected) {
             signUpButton.removeAttr('disabled').attr('aria-disabled', 'false');
         } else {
             signUpButton.attr('disabled', 'disabled').attr('aria-disabled', 'true');
         }
     });

     // Add click event listener to the Sign Up button
     signUpButton.on('click', function (e) {
         const selectedVariation = $('input.variation-radio:checked').val();

         // Show an alert if no variation is selected
         if (!selectedVariation) {
             e.preventDefault(); // Prevent the default behavior
             alert('Please select a variation before proceeding.');
         }
     });
 });
</script>";

}


