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