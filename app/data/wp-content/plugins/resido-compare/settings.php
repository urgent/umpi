<?php
// class Settings {
// 	public function __construct() {
// 		add_filter( 'mb_settings_pages', [ $this, 'register_settings_pages' ] );
// 		add_filter( 'rwmb_meta_boxes', [ $this, 'register_settings_fields' ] );
// 	}
// 	public function register_settings_pages( $settings_pages ) {
// 		$settings_pages['carleader-listings'] = [
// 			'id'          => 'carleader-listings',
// 			'option_name' => 'carleader_listings_options',
// 			'menu_title'  => esc_html__( 'Settings', 'carleader-compare' ),
// 			'parent'      => 'edit.php?post_type=carleader-listing',
// 			'tabs'        => [
// 				'general'  => esc_html__( 'General', 'carleader-compare' ),
// 				'listings' => esc_html__( 'Listings', 'carleader-compare' ),
// 			],
// 		];
// 		return $settings_pages;
// 	}
// 	public function register_settings_fields( $meta_boxes ) {
// 		$files = glob( __DIR__ . '/settings/*.php' );
// 		foreach ( $files as $file ) {
// 			$meta_boxes[] = include $file;
// 		}
// 		return $meta_boxes;
// 	}
// }
// new Settings();
