<?php
class loveicon_Act {
	public function __construct() {
		$this->loveicon_register_action();
	}
	private function loveicon_register_action() {
		add_action( 'loveicon_search_popup_ready', array( 'loveicon_Int', 'loveicon_search_popup' ) );
		add_action( 'loveicon_preloader_ready', array( 'loveicon_Int', 'loveicon_preloader' ) );
		add_action( 'loveicon_slide_menu_ready', array( 'loveicon_Int', 'loveicon_slide_menu' ) );
		add_action( 'loveicon_back_to_top_ready', array( 'loveicon_Int', 'loveicon_back_to_top' ) );
		add_action( 'loveicon_header_logo_ready', array( 'loveicon_Int', 'loveicon_header_logo' ) );
		add_action( 'loveicon_header_menu_ready', array( 'loveicon_Int', 'loveicon_header_menu' ) );
		add_action( 'loveicon_mobile_menu_ready', array( 'loveicon_Int', 'loveicon_mobile_menu' ) );
		add_action( 'loveicon_authore_box_ready', array( 'loveicon_Int', 'loveicon_authore_box' ) );
		add_action( 'loveicon_sticky_header_ready', array( 'loveicon_Int', 'loveicon_sticky_header' ) );

		add_action( 'loveicon_breadcrumb_ready', array( 'loveicon_Int', 'loveicon_breadcrumb' ) );
		add_action( 'loveicon_blog_social_ready', array( 'loveicon_Int', 'loveicon_blog_social' ) );
		add_filter( 'wp_kses_allowed_html', array( 'loveicon_Int', 'loveicon_kses_allowed_html' ), 10, 2 );
	}
}
$loveicon_act = new loveicon_Act();
