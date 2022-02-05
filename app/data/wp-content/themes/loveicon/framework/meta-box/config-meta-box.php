<?php
/**
 * Register meta boxes
 *
 * @return void
 */


add_filter( 'rwmb_meta_boxes', 'loveicon_theme_meta_box' );

function loveicon_theme_meta_box( $meta_boxes ) {
	
	$prefix     = 'loveicon_theme_metabox';
	$posts_page = get_option( 'page_for_posts' );
	if ( ! isset( $_GET['post'] ) || intval( $_GET['post'] ) != $posts_page ) {
		$meta_boxes[] = array(
			'id'       => $prefix . '_page_meta_box',
			'title'    => esc_html__( 'Page Design Settings', 'loveicon' ),
			'pages'    => array(
				'page',
			),
			'context'  => 'normal',
			'priority' => 'core',
			'fields'   => array(
				array(
					'name'            => 'Header style',
					'id'              => "{$prefix}_header_style",
					'type'            => 'select',
					'options'         => array(
						'1' => 'one',
						'2' => 'two ',
						'3' => 'three ',
						'4' => 'four ',
						'5' => 'five ',
					),
					'multiple'        => false,
					'placeholder'     => 'Select an Item',
					'select_all_none' => false,
				),
				array(
					'name'            => 'Header top bar',
					'id'              => "{$prefix}_header_top_barstyle",
					'type'            => 'select',
					'options'         => array(
						'1' => 'one',
						'2' => 'two ',
						'3' => 'three ',
						'4' => 'four ',
						'5	' => 'off ',
					),
					'multiple'        => false,
					'placeholder'     => 'Select an Item',
					'select_all_none' => false,
				),
				array(
					'id'      => "{$prefix}_show_breadcrumb",
					'name'    => esc_html__( 'show breadcrumb', 'loveicon' ),
					'desc'    => '',
					'type'    => 'radio',
					'std'     => 'on',
					'options' => array(
						'on'  => 'on',
						'off' => 'off',
					),
				),
				array(
					'name'            => 'Elementor Library',
					'id'              => "{$prefix}_el_lib",
					'type'            => 'select',
					'options'         => loveicon_elementor_library(),
					'multiple'        => false,
					'placeholder'     => 'Select an Item',
					'select_all_none' => false,
				),      
                array(
                    'type' => 'single_image',
                    'name' => 'Header Logo Changes',
                    'id'   => "{$prefix}_header_logo",
				),
				array(
					'name'            => 'Page main content width',
					'id'              => "{$prefix}_page_col",
					'desc'    => '',
					'type'    => 'radio',
					'std'     => 'off',
					'options' => array(
						'on'  => 'on',
						'off' => 'off',
					),
				),
				array(
					'name' => 'page extra class',
					'id'   => "{$prefix}_page_extra_class",
					'type' => 'text',
				),
			),
		);
	}
	return $meta_boxes;
}
