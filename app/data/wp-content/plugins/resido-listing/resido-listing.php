<?php
/**
 * Plugin Name: Resido Listing
 * Description: A plugin for Resido Theme
 * Plugin URI: smartdatasoft.com/resido
 * Author: SmartDataSoft
 * Author URI: smartdatasoft.com
 * Version: 2.8
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The main plugin class
 */
final class Resido_Listing {


	/**
	 * Plugin version
	 *
	 * @var string
	 */
	const version = '2.0';

	/**
	 * Class construcotr
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'assets_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'custom_admin_scripts' ) );
		add_action( 'widgets_init', array( $this, 'resido_listing_sidebar_init' ) );
		// Register widgets
		add_action( 'wp_enqueue_scripts', array( $this, 'resido_load_more_scripts' ) );
		add_action( 'init', array( $this, 'register_session' ), 1 );
		add_action( 'init', array( $this, 'add_resido_role' ), 1 );
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return \Resido_Listing
	 */
	public static function init() {
		 static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Add a sidebar.
	 */
	public function resido_listing_sidebar_init() {
		register_sidebar(
			array(
				'name'          => __( 'Listing Sidebar', 'resido-listing' ),
				'id'            => 'listingsidebar',
				'description'   => __( 'Widgets in this area will be shown on all Listing sidebar Widgets', 'resido-listing' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget_title">',
				'after_title'   => '</h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => __( 'Listing Single', 'resido-listing' ),
				'id'            => 'listing_single',
				'description'   => __( 'Widgets in this area will be shown on all Listing single page sidebar', 'resido-listing' ),
				'before_widget' => '<div id="%1$s" class="listing-single %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget_title">',
				'after_title'   => '</h4>',
			)
		);
	}

	function custom_admin_scripts() {
		wp_enqueue_script( 'listing-admin-custom', plugins_url( '/assets/admin-custom.js', __FILE__ ), array( 'jquery' ), false, true );
		$ajax_var = array(
			'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
			'site_url' => esc_url( site_url() ),
		);
		wp_localize_script( 'listing-admin-custom', 'ajax_obj', $ajax_var );
	}

	function resido_load_more_scripts() {
		global $wp_query;
		// In most cases it is already included on the page and this line can be removed
		wp_enqueue_script( array( 'jquery' ) );
		// register our main script but do not enqueue it yet
		wp_register_script( 'resido_loadmore', plugins_url( '/assets/resido_loadmore.js', __FILE__ ), array( 'jquery', 'resido-map' ) );
	}

	/**
	 * enqueue scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */

	public function assets_scripts() {
		wp_enqueue_media();
		wp_enqueue_style( 'resido-custom', plugins_url( '/assets/custom.css', __FILE__ ) );

		$listing_option = get_option( 'resido_listings_options' );
		if ( isset( $listing_option['j_map_key'] ) && ! empty( $listing_option['j_map_key'] ) ) {
			wp_enqueue_script( 'resido-maps-google', '//maps.google.com/maps/api/js?key=' . $listing_option['j_map_key'] . '&libraries=places' );
		} else {
			wp_enqueue_script( 'resido-maps-google', '//maps.googleapis.com/maps/api/js?key=&sensor=false&amp;libraries=places' );
		}

		wp_enqueue_script( 'map-infobox', plugins_url( '/assets/map_infobox.js', __FILE__ ), array( 'jquery' ), '', true );
		wp_enqueue_script( 'markerclusterer', plugins_url( '/assets/markerclusterer.js', __FILE__ ), array( 'jquery' ), '', true );
		wp_enqueue_script( 'resido-map', plugins_url( '/assets/map.js', __FILE__ ), array( 'jquery' ), time(), true );
		wp_enqueue_script( 'listing-custom', plugins_url( '/assets/custom.js', __FILE__ ), array( 'jquery', 'resido-map' ), time(), true );
		wp_enqueue_script( 'listing-dropzone', plugins_url( '/assets/dropzone.js', __FILE__ ), array( 'jquery' ), time(), true );

		$location_auto_search     = isset( $listing_option['location_auto_search'] ) ? $listing_option['location_auto_search'] : 'yes';
		$listing_zoom_level       = isset( $listing_option['listing_zoom_level'] ) ? $listing_option['listing_zoom_level'] : 9;
		$listing_center_latitude  = isset( $listing_option['listing_center_latitude'] ) ? $listing_option['listing_center_latitude'] : '40.7';
		$listing_center_longitude = isset( $listing_option['listing_center_longitude'] ) ? $listing_option['listing_center_longitude'] : '73.87';
		$listing_gps_loc_en       = isset( $listing_option['listing_gps_loc_en'] ) ? $listing_option['listing_gps_loc_en'] : 0;
		$action                   = 'resido_adv_search';
		$resido_nonce             = wp_create_nonce( $action );
		$action_ajax              = 'resido_adv_search_ajax';
		$resido_nonce_ajax        = wp_create_nonce( $action_ajax );
		$map_object               = array(
			'RESIDO_IMG_URL'           => esc_url( RESIDO_IMG_URL ),
			'ajax_url'                 => esc_url( admin_url( 'admin-ajax.php' ) ),
			'site_url'                 => esc_url( site_url() ),
			'resido_advs_nonce'        => $resido_nonce,
			'resido_advs_nonce_ajax'   => $resido_nonce_ajax,
			'location_auto_search'     => $location_auto_search,
			'listing_zoom_level'       => $listing_zoom_level,
			'listing_center_latitude'  => $listing_center_latitude,
			'listing_center_longitude' => $listing_center_longitude,
			'listing_gps_loc_en'       => $listing_gps_loc_en,
		);
		wp_localize_script( 'resido-map', 'resido_map_object', $map_object );
		$ajax_var = array(
			'ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
			'site_url' => esc_url( site_url() ),
		);
		wp_localize_script( 'listing-custom', 'ajax_obj', $ajax_var );
	}

	/**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'RESIDO_LISTING_VERSION', self::version );
		define( 'RESIDO_LISTING_FILE', __FILE__ );
		define( 'RESIDO_LISTING_PATH', __DIR__ );
		define( 'RESIDO_LISTING_URL', plugins_url( '', RESIDO_LISTING_FILE ) );
		define( 'RESIDO_LISTING_ASSETS', RESIDO_LISTING_URL . '/assets' );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function init_plugin() {
		 load_plugin_textdomain( 'resido-listing', false, basename( dirname( __FILE__ ) ) . '/languages' );

		if ( is_admin() ) {
		} else {
		}

		include RESIDO_LISTING_PATH . '/includes/admin/rlisting-cpt.php';
		include RESIDO_LISTING_PATH . '/includes/admin/rlisting-meta.php';
		include RESIDO_LISTING_PATH . '/includes/admin/rlisting-redux.php';
		include RESIDO_LISTING_PATH . '/includes/class-subscription.php';
		if ( class_exists( 'WooCommerce' ) ) {
			include RESIDO_LISTING_PATH . '/includes/resido-woo.php';
		}

		require_once RESIDO_LISTING_PATH . '/settings.php';
		require_once RESIDO_LISTING_PATH . '/template-loader.php';
		require_once RESIDO_LISTING_PATH . '/template-tags.php';
		require_once RESIDO_LISTING_PATH . '/shortcode.php';
		require_once RESIDO_LISTING_PATH . '/functions.php';
		require_once RESIDO_LISTING_PATH . '/template-hooks.php';
		require_once RESIDO_LISTING_PATH . '/search-query.php';
		require_once RESIDO_LISTING_PATH . '/ajax.php';
		require_once RESIDO_LISTING_PATH . '/ajax-loadmore.php';

		/*meta box extension*/
		require_once RESIDO_LISTING_PATH . '/extensions/meta-box-columns/meta-box-columns.php';
		require_once RESIDO_LISTING_PATH . '/extensions/meta-box-group/meta-box-group.php';
		require_once RESIDO_LISTING_PATH . '/extensions/mb-term-meta/mb-term-meta.php';
		require_once RESIDO_LISTING_PATH . '/extensions/mb-settings-page/mb-settings-page.php';
		require_once RESIDO_LISTING_PATH . '/extensions/mb-frontend-submission/mb-frontend-submission.php';
		require_once RESIDO_LISTING_PATH . '/extensions/mb-user-profile/mb-user-profile.php';
		require_once RESIDO_LISTING_PATH . '/extensions/meta-box-conditional-logic/meta-box-conditional-logic.php';

		/*
		Widgets*/
		// require_once RESIDO_LISTING_PATH . '/widgets/listing-sidebar.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-sidebar-filter.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-sidebar-search.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-featured-listing.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-recent-listing.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-calculation.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-enquiry-form.php';
		require_once RESIDO_LISTING_PATH . '/widgets/resido-agent-enquiry.php';
	}

	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		require_once RESIDO_LISTING_PATH . '/installer.php';
	}

	public function register_session() {
		if ( ! session_id() ) {
			session_start();
		}
	}

	public function add_resido_role() {
		$result = add_role(
			'resido_admin',
			__( 'Resido Admin', 'resido-listing' ),
			array(
				'read'         => true,  // true allows this capability
				'edit_posts'   => true,
				'delete_posts' => true, // Use false to explicitly deny
			)
		);

		// Let Contributor Role to Upload Media
		if ( current_user_can( 'resido_admin' ) && ! current_user_can( 'upload_files' ) ) {
			add_action( 'admin_init', 'allow_resido_admin_uploads' );
		}
		function allow_resido_admin_uploads() {
			 get_role( 'resido_admin' )->add_cap( 'upload_files' );
		}
	}
}


function function_elem_cpt_support() {
	$cpt_support = get_option( 'elementor_cpt_support' );
	if ( ! $cpt_support ) {
		// First check if the option is not available already in the database. It not then create the array with all default post types including yours and save the settings.
		$cpt_support = array(
			'page',
			'post',
		);
		update_option( 'elementor_cpt_support', $cpt_support );
	} elseif ( ! in_array( 'agent', $cpt_support ) || ! in_array( 'rlisting', $cpt_support ) ) {
		// If the option is available then just append the array and update the settings.
		$cpt_support = array(
			'page',
			'post',
			'agent',
			'rlisting',
		);
		update_option( 'elementor_cpt_support', $cpt_support );
	}
}
// Hook called when the plugin is activated.
add_action( 'plugins_loaded', 'function_elem_cpt_support' );


/**
 * Initializes the main plugin
 *
 * @return \Resido_Listing
 */
function resido_listing() {
	 return Resido_Listing::init();
}

// kick-off the plugin
resido_listing();
