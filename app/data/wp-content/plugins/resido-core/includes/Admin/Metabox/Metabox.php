<?php
namespace Resido\Helper\Admin\Metabox;

class Metabox {





	/**
	 * Initialize the class
	 */
	function __construct() {
		// Register the post type
		add_filter( 'rwmb_meta_boxes', array( $this, 'resido_register_framework_post_meta_box' ) );
	}


	/**
	 * Register meta boxes
	 *
	 * Remember to change "your_prefix" to actual prefix in your project
	 *
	 * @return void
	 */
	function resido_register_framework_post_meta_box( $meta_boxes ) {

		global $wp_registered_sidebars;

		/**
		 * prefix of meta keys (optional)
		 * Use underscore (_) at the beginning to make keys hidden
		 * Alt.: You also can make prefix empty to disable it
		 */
		// Better has an underscore as last sign

		$sidebars = array();

		foreach ( $wp_registered_sidebars as $key => $value ) {
			$sidebars[ $key ] = $value['name'];
		}

		$opacities = array();
		for ( $o = 0.0, $n = 0; $o <= 1.0; $o += 0.1, $n++ ) {
			$opacities[ $n ] = $o;
		}
		$prefix     = 'resido_core';
		$posts_page = get_option( 'page_for_posts' );
		if ( ! isset( $_GET['post'] ) || intval( $_GET['post'] ) != $posts_page ) {
			$meta_boxes[] = array(
				'id'       => $prefix . '_page_wiget_meta_box',
				'title'    => esc_html__( 'Page Settings', 'resido' ),
				'pages'    => array(
					'page',
				),
				'context'  => 'normal',
				'priority' => 'core',
				'fields'   => array(
					array(
						'name'    => esc_html__( 'Show breadcrumb', 'resido' ),
						'id'      => "{$prefix}_show_breadcrumb",
						'type'    => 'radio',
						'desc'    => '',
						'std'     => 'on',
						'options' => array(
							'on'  => 'On',
							'off' => 'Off',
						),
					),
				),
			);
		}

		return $meta_boxes;
	}
}
