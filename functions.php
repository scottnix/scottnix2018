<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
function genesis_sample_localization_setup(){
	load_child_theme_textdomain( 'base_theme', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
// include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS
// include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
// include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Base Child Theme' );
define( 'CHILD_THEME_URL', 'http://scottnix.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);
  wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . "/js/custom.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Footer Menu', 'genesis-sample' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;


}

// custom stuff here for now.

//* Remove the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Customize the site footer
add_action( 'genesis_footer', 'bg_custom_footer' );
function bg_custom_footer() { ?>
  <div class="site-footer"><div class="wrap"><p>Shh!</p></div></div>
<?php
}

//* Unregister content/sidebar layout setting
// genesis_unregister_layout( 'content-sidebar' );
//* Unregister sidebar/content layout setting
// genesis_unregister_layout( 'sidebar-content' );
//* Unregister content/sidebar/sidebar layout setting
// genesis_unregister_layout( 'content-sidebar-sidebar' );
//* Unregister sidebar/sidebar/content layout setting
// genesis_unregister_layout( 'sidebar-sidebar-content' );
//* Unregister sidebar/content/sidebar layout setting
// genesis_unregister_layout( 'sidebar-content-sidebar' );
//* Unregister full-width content layout setting
// genesis_unregister_layout( 'full-width-content' );

//* Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
  return esc_attr( 'Search' );
}

//* Remove Genesis SEO Settings menu link
remove_theme_support( 'genesis-seo-settings-menu' );

//* Remove Genesis in-post SEO Settings
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
  return '<a class="more-link button" href="' . get_permalink() . '">Continue Reading</a>';
}

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    'menu-primary',
    'menu-secondary',
    'site-inner',
    'footer-widgets',
    'footer'
) );