<?php
/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
if ( ! class_exists( 'Redux' ) ) {
	return;
}

// This is your option name where all the Redux data is stored.
$opt_prefix = 'loveicon_';
$opt_name   = 'loveicon_options';
/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name'             => $opt_name,
	// This is where your data is stored in the database and also becomes your global variable name.
	'display_name'         => $theme->get( 'Name' ),
	// Name that appears at the top of your panel
	'display_version'      => $theme->get( 'Version' ),
	// Version that appears at the top of your panel
	'menu_type'            => 'menu',
	// Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu'       => true,
	// Show the sections below the admin menu item or not
	'menu_title'           => esc_html__( 'Loveicon Options', 'loveicon' ),
	'page_title'           => esc_html__( 'Loveicon Options', 'loveicon' ),
	// You will need to generate a Google API key to use this feature.
	// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_api_key'       => '',
	// Set it you want google fonts to update weekly. A google_api_key value is required.
	'google_update_weekly' => false,
	// Must be defined to add google fonts to the typography module
	'async_typography'     => true,
	// Use a asynchronous font on the front end or font string
	// 'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar'            => true,
	// Show the panel pages on the admin bar
	'admin_bar_icon'       => 'dashicons-portfolio',
	// Choose an icon for the admin bar menu
	'admin_bar_priority'   => 50,
	// Choose an priority for the admin bar menu
	'global_variable'      => '',
	// Set a different name for your global variable other than the opt_name
	'dev_mode'             => false,
	// Show the time the page took to load, etc
	'update_notice'        => true,
	// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer'           => true,
	// Enable basic customizer support
	// 'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	// 'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
	// OPTIONAL -> Give you extra features
	'page_priority'        => null,
	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent'          => 'themes.php',
	// For a full list of options, visit: http://cloveicon.wordpress.org/Function_Reference/add_submenu_page#Parameters
	'page_permissions'     => 'manage_options',
	// Permissions needed to access the options panel.
	'menu_icon'            => '',
	// Specify a custom URL to an icon
	'last_tab'             => '',
	// Force your panel to always open to a specific tab (by id)
	'page_icon'            => 'icon-themes',
	// Icon displayed in the admin panel next to your menu_title
	'page_slug'            => '_options',
	// Page slug used to denote the panel
	'save_defaults'        => true,
	// On load save the defaults to DB before user clicks save or not
	'default_show'         => false,
	// If true, shows the default value next to each field that is not the default value.
	'default_mark'         => '',
	// What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export'   => true,
	// Shows the Import/Export panel when not used as a field.
	// CAREFUL -> These options are for advanced use only
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag'           => true,
	// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database'             => '',
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	'use_cdn'              => true,
	// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
	// 'compiler'             => true,
);
Redux::setArgs( $opt_name, $args );
Redux::setSection(
	$opt_name,
	array(
		'title'  => esc_html__( 'Base theme option', 'loveicon' ),
		'id'     => 'base_theme_option',
		'desc'   => esc_html__( 'Chnage Base theme option here', 'loveicon' ),
		'icon'   => 'el el-home',
		'fields' => array(
			array(
				'id'      => $opt_prefix . 'preloader_on_off',
				'type'    => 'switch',
				'title'   => esc_html__( 'Preloader on off switch', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'back_to_top_on_off',
				'type'    => 'switch',
				'title'   => esc_html__( 'Back To Top on off switch', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'footer_base_css',
				'type'    => 'switch',
				'title'   => esc_html__( 'Footer base css', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'blog_single_base_css',
				'type'    => 'switch',
				'title'   => esc_html__( 'Blog single base css', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'blog_list_base_css',
				'type'    => 'switch',
				'title'   => esc_html__( 'Blog list base css', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'theme_base_css',
				'type'    => 'switch',
				'title'   => esc_html__( 'theme base css', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'theme_box_mode',
				'type'    => 'switch',
				'title'   => esc_html__( 'theme box mode', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
		),
	)
);
Redux::setSection(
	$opt_name,
	array(
		'title'  => esc_html__( 'Header theme option', 'loveicon' ),
		'id'     => 'header_theme_option',
		'desc'   => esc_html__( 'Change Header theme option here', 'loveicon' ),
		'icon'   => 'el el-home',
		'fields' => array(
			array(
				'id'      => $opt_prefix . 'header_menu_style',
				'type'    => 'select',
				'title'   => esc_html__( 'Header menu style', 'loveicon' ),
				'options' => array(
					'1' => esc_html__( 'One', 'loveicon' ),
					'2' => esc_html__( 'Two', 'loveicon' ),
					'3' => esc_html__( 'Three', 'loveicon' ),
					'4' => esc_html__( 'Four', 'loveicon' ),
					'5' => esc_html__( 'Five', 'loveicon' ),
				),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_style', '=', array( '1', '2', '3', '5' ) ),
				'id'       => $opt_prefix . 'header_menu_button_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Button text', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_style', '=', array( '1', '2', '3', '5' ) ),
				'id'       => $opt_prefix . 'header_menu_button_url',
				'type'     => 'text',
				'title'    => esc_html__( 'Button url', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_style', '=', array( '1', '2', '3', '5' ) ),
				'id'       => $opt_prefix . 'header_menu_sidebar',
				'type'     => 'switch',
				'title'    => esc_html__( 'sidebar menu enable', 'loveicon' ),
				'default'  => false,
				'on'       => esc_html__( 'Enable', 'loveicon' ),
				'off'      => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_sidebar', '=', '1' ),
				'id'       => $opt_prefix . 'header_menu_sidebar_title',
				'type'     => 'text',
				'title'    => esc_html__( 'title', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_sidebar', '=', '1' ),
				'id'       => $opt_prefix . 'header_menu_sidebar_content',
				'type'     => 'textarea',
				'title'    => esc_html__( 'content', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_sidebar', '=', '1' ),
				'id'       => $opt_prefix . 'header_menu_sidebar_quet_title',
				'type'     => 'text',
				'title'    => esc_html__( 'quote title', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_sidebar', '=', '1' ),
				'id'       => $opt_prefix . 'header_menu_sidebar_quet_shortcode',
				'type'     => 'text',
				'title'    => esc_html__( 'quote shortcode', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_menu_style', '=', array( '2', '3', '4' ) ),
				'id'       => $opt_prefix . 'header_menu_search',
				'type'     => 'switch',
				'title'    => esc_html__( 'search enable', 'loveicon' ),
				'default'  => false,
				'on'       => esc_html__( 'Enable', 'loveicon' ),
				'off'      => esc_html__( 'Disable', 'loveicon' ),
			),
		),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Header top bar', 'loveicon' ),
		'id'         => 'header_top_bar',
		'subsection' => true,
		'icon'       => 'el el-home',
		'fields'     => array(
			array(
				'id'      => $opt_prefix . 'header_top_style',
				'type'    => 'select',
				'title'   => esc_html__( 'Header top style', 'loveicon' ),
				'options' => array(
					'1' => esc_html__( 'One', 'loveicon' ),
					'2' => esc_html__( 'Two', 'loveicon' ),
					'3' => esc_html__( 'Three', 'loveicon' ),
					'4' => esc_html__( 'Four', 'loveicon' ),
				),
			),
			array(
				'id'      => $opt_prefix . 'header_top_bar_slider',
				'type'    => 'switch',
				'title'   => esc_html__( 'Top bar slider', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'required'    => array( $opt_prefix . 'header_top_style', '=', array( '1' ) ),
				'id'          => $opt_prefix . 'header_top_bar_slider',
				'type'        => 'slides',
				'title'       => esc_html__( 'Top bar slider / upload option not allow here ', 'loveicon' ),
				'placeholder' => array(
					'title' => __( 'single item for slide', 'loveicon' ),
				),
				'show'        => array(
					'title'       => true,
					'description' => false,
					'url'         => false,
				),
			),
			array(
				'required'    => array( $opt_prefix . 'header_top_style', '=', array( '1', '2', '3' ) ),
				'id'          => $opt_prefix . 'header_top_bar_social',
				'type'        => 'slides',
				'title'       => esc_html__( 'social slider', 'loveicon' ),
				'placeholder' => array(
					'title' => __( 'single url of social link', 'loveicon' ),
				),
				'show'        => array(
					'title'       => true,
					'description' => false,
					'url'         => false,
				),
			),
			array(
				'required'    => array( $opt_prefix . 'header_top_style', '=', array( '4' ) ),
				'id'          => $opt_prefix . 'header_top_bar_menu',
				'type'        => 'slides',
				'title'       => esc_html__( 'menu slider', 'loveicon' ),
				'placeholder' => array(
					'title'       => __( 'menu link', 'loveicon' ),
					'description' => __( 'menu title', 'loveicon' ),
				),
				'show'        => array(
					'title'       => true,
					'description' => true,
					'url'         => false,
				),
			),
			array(
				'required' => array( $opt_prefix . 'header_top_style', '=', array( '2', '3', '4' ) ),
				'id'       => $opt_prefix . 'header_top_bar_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'phone', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_top_style', '=', array( '2', '3', '4' ) ),
				'id'       => $opt_prefix . 'header_top_bar_map',
				'type'     => 'text',
				'title'    => esc_html__( 'map', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_top_style', '=', array( '2' ) ),
				'id'       => $opt_prefix . 'header_top_bar_lang',
				'type'     => 'ace_editor',
				'title'    => esc_html__( 'language', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_top_style', '=', array( '3' ) ),
				'id'       => $opt_prefix . 'header_top_bar_button_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Button text', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'header_top_style', '=', array( '3' ) ),
				'id'       => $opt_prefix . 'header_top_bar_button_url',
				'type'     => 'text',
				'title'    => esc_html__( 'Button url', 'loveicon' ),
			),
			array(
				'required'    => array( $opt_prefix . 'header_top_style', '=', array( '3' ) ),
				'id'          => $opt_prefix . 'header_mdl_bar_slider',
				'type'        => 'slides',
				'title'       => esc_html__( 'Top bar slider / upload option not allow here ', 'loveicon' ),
				'placeholder' => array(
					'title' => __( 'single item for slide', 'loveicon' ),
				),
				'show'        => array(
					'title'       => true,
					'description' => false,
					'url'         => false,
				),
			),
		),
	)
);



Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'sticky header Menu', 'loveicon' ),
		'id'         => 'sticky_header_menu_option',
		'subsection' => true,
		'desc'       => esc_html__( 'Chnage Header Menu option here', 'loveicon' ),
		'icon'       => 'el el-home',
		'fields'     => array(
			array(
				'id'      => $opt_prefix . 'sticky_header_on',
				'type'    => 'switch',
				'title'   => esc_html__( 'sticky header on off switch', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'sticky_header_on', '=', '1' ),
				'id'       => $opt_prefix . 'sticky_header_logo',
				'type'     => 'media',
				'url'      => true,
				'title'    => esc_html__( 'sticky header logo', 'loveicon' ),
			),
		),
	)
);
Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Mobile Menu', 'loveicon' ),
		'id'         => 'mobile_menu_option',
		'subsection' => true,
		'desc'       => esc_html__( 'Chnage mobile Menu option here', 'loveicon' ),
		'icon'       => 'el el-home',
		'fields'     => array(
			array(
				'id'    => $opt_prefix . 'mobile_menu_logo',
				'type'  => 'media',
				'url'   => true,
				'title' => esc_html__( 'mobile logo', 'loveicon' ),
			),
			array(
				'id'          => $opt_prefix . 'mobile_menu_social',
				'type'        => 'slides',
				'title'       => esc_html__( 'mobile contact social', 'loveicon' ),
				'placeholder' => array(
					'title' => __( 'svg link', 'loveicon' ),
					'url'   => __( 'svg alt', 'loveicon' ),
				),
				'show'        => array(
					'title'       => true,
					'description' => false,
					'url'         => true,
				),
			),
		),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'            => esc_html__( 'Typography', 'loveicon' ),
		'id'               => 'fonts_settings',
		'desc'             => esc_html__( 'Typography', 'loveicon' ),
		'customizer_width' => '400px',
		'icon'             => 'el el-font',
		'fields'           => array(
			array(
				'id'       => 'enable_typography',
				'type'     => 'switch',
				'title'    => esc_html__( 'Typography', 'loveicon' ),
				'subtitle' => esc_html__( 'Enable or Disable Typography', 'loveicon' ),
				'default'  => false,
				'off'      => esc_html__( 'Disable', 'loveicon' ),
				'on'       => esc_html__( 'Enable', 'loveicon' ),
			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-body_typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'Body Typography', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select body font family, size, line height, color and weight.', 'loveicon' ),
				'text-align' => false,
				'subsets'    => false,
				'output'     => array( 'body' ),

			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-heading-1-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'H1 Font', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select heading font family and weight.', 'loveicon' ),
				'google'     => true,
				'text-align' => false,
				'output'     => array( 'h1' ),
			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-heading-2-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'H2 Font', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select heading font family and weight.', 'loveicon' ),
				'google'     => true,
				'text-align' => false,
				'output'     => array( 'h2' ),

			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-heading-3-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'H3 Font', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select heading font family and weight.', 'loveicon' ),
				'google'     => true,
				'text-align' => false,
				'output'     => array( 'h3' ),
			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-heading-4-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'H4 Font', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select heading font family and weight.', 'loveicon' ),
				'google'     => true,
				'text-align' => false,
				'output'     => array( 'h4' ),
			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-heading-5-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'H5 Font', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select heading font family and weight.', 'loveicon' ),
				'google'     => true,
				'text-align' => false,
				'output'     => array( 'h5' ),
			),
			array(
				'required'   => array( 'enable_typography', '=', '1' ),
				'id'         => $opt_prefix . '-heading-6-typography',
				'type'       => 'typography',
				'title'      => esc_html__( 'H6 Font', 'loveicon' ),
				'subtitle'   => esc_html__( 'Select heading font family and weight.', 'loveicon' ),
				'google'     => true,
				'text-align' => false,
				'output'     => array( 'h6' ),
			),

		),
	)
);
Redux::setSection(
	$opt_name,
	array(
		'title'  => esc_html__( 'Breadcrumb area', 'loveicon' ),
		'id'     => 'breadcrumb_area',
		'icon'   => 'el el-home',
		'fields' => array(
			array(
				'id'      => $opt_prefix . 'blog_breadcrumb_switch',
				'type'    => 'switch',
				'title'   => esc_html__( 'Blog breadcrumb on off switch', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'required' => array( $opt_prefix . 'blog_breadcrumb_switch', '=', '1' ),
				'id'       => $opt_prefix . 'blog_breadcrumb_bg',
				'type'     => 'background',
				'url'      => true,
				'title'    => esc_html__( 'Blog breadcrumb background', 'loveicon' ),
				'output'   => array(
					'background' => '.blog-breadcrumb',
				),
			),
			array(
				'required' => array( $opt_prefix . 'blog_breadcrumb_switch', '=', '1' ),
				'id'       => $opt_prefix . 'blog_breadcrumb_content',
				'type'     => 'text',
				'title'    => esc_html__( 'Blog breadcrumb title', 'loveicon' ),
				'default'  => esc_html__( 'Blog Page', 'loveicon' ),
			),
			array(
				'id'     => $opt_prefix . 'blog_single_breadcrumb_bg',
				'type'   => 'background',
				'url'    => true,
				'title'  => esc_html__( 'Blog Single breadcrumb background', 'loveicon' ),
				'output' => array(
					'background' => '.blog-single-breadcrumb',
				),
			),
		),
	)
);
Redux::setSection(
	$opt_name,
	array(
		'title'  => esc_html__( 'Blog option', 'loveicon' ),
		'id'     => 'blog_option_panale',
		'desc'   => esc_html__( 'Change blog option', 'loveicon' ),
		'icon'   => 'el el-home',
		'fields' => array(
			array(
				'id'      => $opt_prefix . 'blog_authore_switch',
				'type'    => 'switch',
				'title'   => esc_html__( 'Blog authore box on off switch', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'blog_style',
				'type'    => 'select',
				'title'   => esc_html__( 'Blog style', 'loveicon' ),
				'options' => array(
					'1' => esc_html__( 'One', 'loveicon' ),
					'2' => esc_html__( 'Two', 'loveicon' ),
				),
			),
			array(
				'id'      => $opt_prefix . 'blog_single_social',
				'type'    => 'switch',
				'title'   => esc_html__( 'social share', 'loveicon' ),
				'default' => false,
				'on'      => esc_html__( 'Enable', 'loveicon' ),
				'off'     => esc_html__( 'Disable', 'loveicon' ),
			),
			array(
				'id'      => $opt_prefix . 'blog_grid_date',
				'type'    => 'select',
				'title'   => esc_html__( 'Blog Grid date style', 'loveicon' ),
				'options' => array(
					'1' => esc_html__( 'One', 'loveicon' ),
					'2' => esc_html__( 'Two', 'loveicon' ),
				),
			),
		),
	)
);
Redux::setSection(
	$opt_name,
	array(
		'title'  => esc_html__( 'Footer Option', 'loveicon' ),
		'id'     => 'footer_widget_option',
		'icon'   => 'el el-home',
		'fields' => array(
			array(
				'id'      => $opt_prefix . 'footer_left_widget_elementor',
				'type'    => 'select',
				'multi'   => false,
				'title'   => esc_html__( 'Footer Builder', 'loveicon' ),
				'options' => loveicon_elementor_library(),
			),
			array(
				'id'    => $opt_prefix . 'footer_copyright',
				'type'  => 'textarea',
				'title' => esc_html__( 'Copyright text', 'loveicon' ),
			),
		),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'  => esc_html__( 'Color option', 'loveicon' ),
		'id'     => 'loveicon_color_area',
		'desc'   => esc_html__( 'Chnage Color option here', 'loveicon' ),
		'icon'   => 'el el-home',
		'fields' => array(
			array(
				'id'          => $opt_prefix . 'main_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Primary Color', 'loveicon' ),
				'subtitle'    => esc_html__( 'Pick a color for the theme (default: #f8952c).', 'loveicon' ),
				'validate'    => 'color',
				'transparent' => false,
			),

		),
	)
);
