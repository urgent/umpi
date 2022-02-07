<?php
add_filter(
	'pt-ocdi/replace_url',
	function () {
		return array('https://resido.smartdemowp.com');
	}
);

add_filter(
	'pt-ocdi/domain_name',
	function () {
		return array('smartdemowp.com');
	}
);

add_filter(
	'pt-ocdi/destination_path',
	function () {
		return '/wp-content/plugins/resido-demo-installer/images/';
	}
);

add_filter(
	'pt-ocdi/import_files',
	function () {
		return array(
			array(
				'import_file_name'             => esc_html__('Resido', 'chaoz'),
				'local_import_file'            => plugin_dir_path(__FILE__) . 'demo-data/demo1/contents.xml',
				'local_import_widget_file'     => plugin_dir_path(__FILE__) . 'demo-data/demo1/widgets.wie',
				'import_preview_image_url'     => plugin_dir_url(__FILE__) . 'demo-data/demo1/screen-image.png',
				'local_import_customizer_file' => plugin_dir_path(__FILE__) . 'demo-data/demo1/customize.dat',
				'import_notice'                => esc_html__('Install and active all required plugins before you click on the "Yes! Important" button.', 'chaoz'),
				'preview_url'                  => 'https://resido.smartdemowp.com',
				'local_import_redux'           => array(
					array(
						'file_path'   => plugin_dir_path(__FILE__) . 'demo-data/demo1/settings.json',
						'option_name' => 'resido_options',
					),
				),
			),
		);
	},
	15
);


add_action(
	'pt-ocdi/after_import',
	function () {
		$main_menu  = get_term_by('name', 'Main Menu', 'nav_menu');
		$menu_array = array();
		if (isset($main_menu->term_id)) {
			$menu_array['primary'] = $main_menu->term_id;
		}
		set_theme_mod(
			'nav_menu_locations',
			$menu_array
		);
		$home_page = get_page_by_title('Home Layout 1');
		update_option('page_on_front', $home_page->ID);
		update_option('show_on_front', 'page');
		$blog_page = get_page_by_title('Our Articles');
		update_option('page_for_posts', $blog_page->ID);
	}
);

$token = get_option('envato_theme_license_token');
if ($token != '') {
	add_filter(
		'pt-ocdi/plugin_page_setup',
		function () {
			return array(
				'parent_slug' => 'envato-theme-license-dashboard',
				'page_title'  => esc_html__('One Click Demo Import', 'pt-ocdi'),
				'menu_title'  => esc_html__('Import Demo Data', 'pt-ocdi'),
				'capability'  => 'manage_options',
				'menu_slug'   => 'envato-theme-license-one-click-demo-import',
			);
		}
	);
} else {
	add_filter(
		'pt-ocdi/plugin_page_setup',
		function () {
			return array(
				'parent_slug' => '',
				'page_title'  => '',
				'menu_title'  => '',
				'capability'  => '',
				'menu_slug'   => '',
			);
		}
	);
}
add_filter('pt-ocdi/disable_pt_branding', '__return_true');
