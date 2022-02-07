<?php
namespace Resido\Helper;

class Widgets {



	/**
	 * Initialize the class
	 */
	function __construct() {
		// Register the post type
		add_action( 'widgets_init', array( $this, 'widgets_registered' ) );
	}

	public function widgets_registered() {
		register_widget( new Widgets\Widget_Selector() );
		register_widget( new Widgets\Recent_Posts() );
		register_widget( new Widgets\Service_Sidebar_Menu() );
	}
}
