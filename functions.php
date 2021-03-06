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

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'genesis-sample', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'genesis-sample' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'StanhopeNJ' );
define( 'CHILD_THEME_URL', 'http://stanhopenj.gov/' );
define( 'CHILD_THEME_VERSION', '2.2.3' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'stanhopenj-fonts', '//fonts.googleapis.com/css?family=Lora:400,700|Lato:400,700);', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'stanhopenj-nav-css', get_stylesheet_directory_uri() . '/style_navigation.css' );
	wp_enqueue_style( 'stanhopenj-media-css', get_stylesheet_directory_uri() . '/style_media.css' );
	wp_enqueue_style( 'stanhopenj-print-css', get_stylesheet_directory_uri() . '/style_print.css' );


	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'genesis-sample' ),
		'subMenu'  => __( 'Menu', 'genesis-sample' ),
	);

	//* type-sizer *//
	wp_enqueue_script( 'stanhopenj-type-sizer', get_bloginfo( 'stylesheet_directory' ) . '/js/type-sizer.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'js-cookie', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery.cookie.js', 'stanhopenj-type-sizer' );

	wp_localize_script( 'genesis-sample-responsive-menu', 'genesisSampleL10n', $output );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Change placeholder search form text
add_filter( 'genesis_search_text', 'stanhopnj_search_button_text' );
function stanhopnj_search_button_text( $text ) {
    return "I'm looking for...";
}

// Remove the edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );



//Remove end date on the Events Calendar
function tribe_remove_end_time_single( $formatting_details ) {
	$formatting_details['show_end_time'] = 0;
	return $formatting_details;
}
add_filter( 'tribe_events_event_schedule_details_formatting', 'tribe_remove_end_time_single', 10, 2);

function tribe_remove_end_time_tooltips( $json_array, $event, $additional ) {
	$json_array['endTime'] = '';
	return $json_array;
}
add_filter( 'tribe_events_template_data_array', 'tribe_remove_end_time_tooltips', 10, 3 );

function tribe_remove_endtime_multiday ( $inner, $event ) {
	if ( tribe_event_is_multiday( $event ) && ! tribe_event_is_all_day( $event ) ) {
		$format                   = tribe_get_date_format( true );
		$time_format              = get_option( 'time_format' );
		$format2ndday             = apply_filters( 'tribe_format_second_date_in_range', $format, $event );
		$datetime_separator       = tribe_get_option( 'dateTimeSeparator', ' @ ' );
		$time_range_separator     = tribe_get_option( 'timeRangeSeparator', ' - ' );
		$microformatStartFormat   = tribe_get_start_date( $event, false, 'Y-m-dTh:i' );
		$microformatEndFormat     = tribe_get_end_date( $event, false, 'Y-m-dTh:i' );
		$inner = '<span class="date-start dtstart">';
		$inner .= tribe_get_start_date( $event, false, $format ) . $datetime_separator . tribe_get_start_date( $event, false, $time_format );
		$inner .= '<span class="value-title" title="' . $microformatStartFormat . '"></span>';
		$inner .= '</span>' . $time_range_separator;
		$inner .= '<span class="date-end dtend">';
		$inner .= tribe_get_end_date( $event, false, $format2ndday );
		$inner .= '<span class="value-title" title="' . $microformatEndFormat . '"></span>';
		$inner .= '</span>';
	}
	return $inner;
}
add_filter( 'tribe_events_event_schedule_details_inner', 'tribe_remove_endtime_multiday', 10, 3 );



// Customize the post info function
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_date]';
	return $post_info;
}}

// Events category archives should have content instead of excerpt
add_action( 'genesis_before', 'child_conditional_actions' );
function child_conditional_actions() {
    if( is_post_type_archive('tribe_events') ) {

        remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
        remove_action( 'genesis_entry_content', 'genesis_do_post_image' );
        add_action( 'genesis_entry_content', 'the_content' );
    }
}

// Add Read More Link to Excerpts
// Front Page News excerpts are links instead of buttons
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
	if ( is_front_page() ) {
	   return '...</p><a class="front-page-read-more" href="' . get_permalink() . '" >Read More...</a>';
	} else {
	   return '...</p><a class="button small" href="' . get_permalink() . '" >Read More</a>';
	}
}

// Add Gradient over header image for readability
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
add_action( 'genesis_header', 'stanhopenj_header_markup_open', 5 );
function stanhopenj_header_markup_open() {

	if ( is_front_page() ) {

		genesis_markup( array(
			'html5'   => '<div class="site-header-border"></div>
						<header %s>
						<div class="home-header-ghost">
							<img src="'. get_stylesheet_directory_uri() .'/images/empty-290.png">
						</div>
						<div class="header-logo"><a href="'.home_url().'"><img src="'. get_stylesheet_directory_uri() .'/images/stanhope-borough.png"></a></div>',
			'xhtml'   => '<div id="header">',
			'context' => 'site-header',
		) );

	} else {

		genesis_markup( array(
			'html5'   => '<div class="site-header-border"></div>
						<header %s>
						<div class="page-header-ghost">
							<img src="'. get_stylesheet_directory_uri() .'/images/empty-190.png">
						</div>
						<div class="header-logo"><a href="'.home_url().'"><img src="'. get_stylesheet_directory_uri() .'/images/stanhope-borough.png"></a></div>',
			'xhtml'   => '<div id="header">',
			'context' => 'site-header',
		) );
	}

	genesis_structural_wrap( 'header' );
}

// Add Conditional Widgets support (UI & Logic) for post type 'tribe_events' and taxonomy 'category'
// example: 'tribe_events_cat' => 'featured'
add_filter('conditional_widgets_type_tax_pairs', 'stanhopenj_conditional_widget_type_tax_pairs' );
function stanhopenj_conditional_widget_type_tax_pairs( $pairs_array ) {

	$stanhopenj_pair = array('tax'=>'tribe_events_cat', 'type'=>'tribe_events');
	$pairs_array[] = $stanhopenj_pair;
	return $pairs_array;
}

// Remove style sheet from Visual Form Builder
add_filter( 'visual-form-builder-css', '__return_false' );

// Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );

// Remove breadcrumb from /events or /events/month
add_action( 'genesis_before', 'stanhopenj_remove_genesis_breadcrumb' );

function add_breadcrumb_replace() {
	echo '<div class="breadcrumb-replace"></div>';
}

function stanhopenj_remove_genesis_breadcrumb() {

	if ( tribe_is_month() && !is_tax() ) {
		remove_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );
		add_action( 'genesis_after_header', 'add_breadcrumb_replace' );
		//add_filter( 'body_class', 'sp_body_class' ); //this doesn't work
	}
}

add_filter( 'body_class','my_body_classes' );
function my_body_classes( $classes ) {

    if ( tribe_is_month() && !is_tax() ) {
        $classes[] = 'events-month';
    }

    return $classes;
}

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

// add the alert front-page widget
genesis_register_sidebar( array(
	'id'		=> 'alert-box',
	'name'		=> __( 'Alert Box', 'genesis-sample' ),
	'description'	=> __( 'This is the widget area for the front page in case there is an alert to display. Move the text widget from Inactive Widgets into it to display. Move the text widget to Inactive Widgets to hide.', 'genesis-sample' ),
) );

// add the events front-page widget
genesis_register_sidebar( array(
	'id'		=> 'upcoming-events',
	'name'		=> __( 'Upcoming Events', 'genesis-sample' ),
	'description'	=> __( 'This is the widget area for the front page Upcoming Events.', 'genesis-sample' ),
) );

//* Add Image Sizes
add_image_size( 'featured-image', 720, 400, TRUE );
add_image_size( 'events-home', 400, 300, true );

//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Footer Menu', 'genesis-sample' ) ) );

// Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; All rights reserved. &middot; <a href="http://curioelectro.com/" target="_blank">Web Design and Development by&nbsp;Curio&nbsp;Electro</a>';
	return $creds;
}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

//* The secondary navigation menu depth
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 2;

	return $args;
}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {

	return 90;
}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;
}
