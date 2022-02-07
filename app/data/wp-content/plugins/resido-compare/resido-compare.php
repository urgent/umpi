<?php
/*
  Plugin Name: Resido Compare
  Plugin URI: http://smartdatasoft.com/
  Description: Helping  Compare Plug In for the SmartDataSoft  theme.
  Author: SmartDataSoft Team
  Version: 1.0
  Author URI: http://smartdatasoft.com/
*/

// Define Constants

if (!defined('ABSPATH')) {
	exit;
}

// if (has_action('resido_theme_init')) {


// 	add_action('resido_theme_init', 'check_resido_theme_active');

// 	function check_resido_theme_active()
// 	{
// 		if (!function_exists('resido_setup')) {
// 			return;
// 		}
// 	}
// }

if (!defined('RESIDO_THEME_URI')) {
	define('RESIDO_THEME_URI', get_template_directory_uri());
}

if (!defined('RESIDO_PLUGIN_URI')) {
	define('RESIDO_PLUGIN_URI', plugin_dir_url(__FILE__));
}

if (!defined('RESIDO_COMPARE_PLUGIN_DIR')) {
	define('RESIDO_COMPARE_PLUGIN_DIR', dirname(__FILE__) . '/');
}

if (!defined('RESIDO_COMPARE_PLUGIN_SETTINGS_DIR')) {
	define('RESIDO_COMPARE_PLUGIN_SETTINGS_DIR', dirname(__FILE__) . '/settings/');
}



add_action('plugins_loaded', 'carleader_compare_load_textdomain');

function carleader_compare_load_textdomain()
{
	load_plugin_textdomain('resido-compare', false, basename(dirname(__FILE__)) . '/languages');
}

add_action('mb_settings_pages', 'register_settings_compare_pages');

function register_settings_compare_pages($settings_pages)
{
	$settings_pages['resido-compare'] = [
		'id' => 'resido-listings-compare',
		'option_name' => 'resido_listings_options',
		'menu_title' => esc_html__('Compare', 'resido-listing'),
		'parent' => 'edit.php?post_type=rlisting',
		'tabs' => [
			'compare' => esc_html__('Compare', 'resido-listing'),
		],
	];
	return $settings_pages;
}



add_action('plugins_loaded', 'resido_listing_check');

function resido_listing_check()
{

	if (class_exists('Resido_Listing')) {
		function get_term_list()
		{
			$rlisting_features = get_terms(
				array(
					'taxonomy' => 'rlisting_features',
					'hide_empty' => false,
				)
			);
			$options = array();
			$options[''] = 'All';

			foreach ($rlisting_features as $feature) {
				$options[$feature->slug] = $feature->name;
			}
			return $options;
		}

		function register_compare_fields($meta_boxes)
		{

			$meta_boxes[] = array(
				'id' => 'compare_listing',
				'title' => esc_html__('Listing Enquiry Message', 'resido-listing'),
				'settings_pages' => 'resido-listings-compare',
				'tab' => 'compare',
				'col' => '12',
				'fields' => [
					array(
						'name'            => 'Select Feature Fields',
						'id'              => 'select_ff',
						'type'            => 'select_advanced',
						'options'         => get_term_list(),
						'multiple'        => true,
						'placeholder'     => 'Select an Item',
						'select_all_none' => false,
					)
				],
			);
			return $meta_boxes;
		}
		add_action('rwmb_meta_boxes', 'register_compare_fields');
	}
}


// Require Init Class

require_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/resido-comapre-class-init.php';

use RESIDO_COMPARE\includes\CompareClassActivate\Resido_Compare_Activate;

// Call when activate the plugin

register_activation_hook(__FILE__, 'activate_resido_compare');
function activate_resido_compare()
{
	Resido_Compare_Activate::carleader_compare_activation_func();
	Resido_Compare_Activate::resido_compare_create_page();
}
