<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package loveicon
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function loveicon_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
    }
    $theme_base_css   = loveicon_get_options( 'theme_base_css' );
    $theme_base_css_class = 'base-theme';
	if($theme_base_css == 1 ) :
		$theme_base_css_class = '';
    endif;

    $classes[] = $theme_base_css_class;

    $loveicon_theme_metabox_box_layout = get_post_meta(get_the_ID(), 'loveicon_theme_metabox_box_layout', true);
    $theme_box_mode   = loveicon_get_options( 'theme_box_mode' );
    $theme_box_mode_class = '';
	if($theme_box_mode == 1 || $loveicon_theme_metabox_box_layout == 'on') :
		$theme_base_css_class = 'main_page active_boxlayout bg';
    endif;

    $classes[] = $theme_base_css_class;

    

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
    }
	

	return $classes;
}
add_filter( 'body_class', 'loveicon_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function loveicon_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'loveicon_pingback_header' );
/**
 * Add kses wp.
 */
function loveicon_kses_allowed_html($loveicon_tags, $loveicon_context) {
    switch ($loveicon_context) {
        case 'loveicon_kses':
            $loveicon_tags = array(
                'a' => array('href' => array()),
                'p' => array(),
                'em' => array(),
                'span' => array(),
                'strong' => array()
            );
            return $loveicon_tags;
        case 'loveicon_img':
            $loveicon_tags = array(
                'img' => array('class' => array(), 'height' => array(), 'width' => array(), 'src' => array(), 'alt' => array())
            );
            return $loveicon_tags;
        default:
            return $loveicon_tags;
    }
}

add_filter('wp_kses_allowed_html', 'loveicon_kses_allowed_html', 10, 2);
