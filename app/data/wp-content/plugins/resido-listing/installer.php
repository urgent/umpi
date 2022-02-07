<?php
/**
 * Installer class
 */
class Installer {


	/**
	 * Run the installer
	 *
	 * @return void
	 */
	public function run() {
		$this->add_version();
		$this->create_tables();
		$this->resido_add_custom_page();
	}

	/**
	 * Add time and version on DB
	 */
	public function add_version() {

		$installed = get_option( 'resido_listing_installed' );
		if ( ! $installed ) {
			update_option( 'resido_listing_installed', time() );
		}
		update_option( 'RESIDO_LISTING_VERSION', RESIDO_LISTING_VERSION );
	}

	/**
	 * Create necessary database tables
	 *
	 * @return void
	 */
	public function create_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$schema          = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}enquiry_message` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `email` varchar(30) DEFAULT NULL,
          `phone` varchar(30) DEFAULT NULL,
          `message` varchar(255) DEFAULT NULL,
          `created_for` bigint(20) unsigned NOT NULL,
          `created_at` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) $charset_collate";

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

		dbDelta( $schema );
	}

	function resido_add_custom_page() {
		// Create post object
		$listing_page = array(
			'post_title'   => 'Add Listing',
			'post_content' => '[listing-submit-page]',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'page',
		);
		// Insert the post into the database

		$page = get_page_by_title( 'Add Listing' );
		if ( ! $page ) {
			wp_insert_post( $listing_page );
		}

		$listing_dashboard = array(
			'post_title'   => 'Dashboard',
			'post_content' => '[listing-user-dashboard]',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'page',
		);
		// Insert the post into the database
		$page = get_page_by_title( 'Dashboard' );
		if ( ! $page ) {
			wp_insert_post( $listing_dashboard );
		}
	}
}

$installer = new Installer();
$installer->run();
