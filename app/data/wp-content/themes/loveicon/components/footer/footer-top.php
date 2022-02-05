<?php
$footer_left_widget_elementor = loveicon_get_options( 'footer_left_widget_elementor' );
if ( class_exists( '\\Elementor\\Plugin' ) ) :
	$pluginElementor              = \Elementor\Plugin::instance();
	$footer_left_widget_elementor = $pluginElementor->frontend->get_builder_content( $footer_left_widget_elementor );
	echo do_shortcode( $footer_left_widget_elementor );
endif;
