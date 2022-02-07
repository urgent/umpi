<?php

/**
 * The RListing_CPT handler class
 */
class RListing_CPT {


	/**
	 * Initialize the class
	 */
	function __construct() {
		add_action( 'init', array( $this, 'resido_lcpt' ) );
		add_action( 'init', array( $this, 'resido_agencies' ) );
		add_action( 'init', array( $this, 'resido_agent' ) );
		// add_action('init', [$this, 'resido_lcpt_rooms']);
		add_action( 'init', array( $this, 'resido_lcpt_taxonomies' ), 0 );
		add_action( 'init', array( $this, 'resido_pricing_plan' ), 0 );
	}

	public function resido_lcpt() {
		$listing_option       = resido_listing_option();
		$listing_details_slug = isset( $listing_option['listing_details_slug'] ) ? $listing_option['listing_details_slug'] : 'listing';
		$listings_slug        = isset( $listing_option['listing_slug'] ) ? $listing_option['listing_slug'] : 'listings';
		$labels               = array(
			'name'               => _x( 'Listings', 'resido-listing' ),
			'singular_name'      => _x( 'Listing', 'resido-listing' ),
			'add_new'            => _x( 'Add New', 'resido-listing' ),
			'add_new_item'       => __( 'Add New Listing', 'resido-listing' ),
			'edit_item'          => __( 'Edit Listing', 'resido-listing' ),
			'new_item'           => __( 'New Listing', 'resido-listing' ),
			'all_items'          => __( 'All Listings', 'resido-listing' ),
			'view_item'          => __( 'View Listing', 'resido-listing' ),
			'search_items'       => __( 'Search Listings', 'resido-listing' ),
			'not_found'          => __( 'No products found', 'resido-listing' ),
			'not_found_in_trash' => __( 'No products found in the Trash', 'resido-listing' ),
			'parent_item_colon'  => '',
			'menu_name'          => _x( 'Listings', 'resido-listing' ),
		);
		$args                 = array(
			'labels'        => $labels,
			'menu_icon'     => 'dashicons-excerpt-view',
			'description'   => 'Holds our listings and listing specific data',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revision', 'author' ),
			'taxonomies'    => array( 'rlisting_category', 'post_tag', 'rlisting_location', 'rlisting_status', 'rlisting_features' ),
			'rewrite'       => array(
				'slug'       => untrailingslashit( $listing_details_slug ),
				// 'slug' => 'listing',
				'with_front' => false,
				'feeds'      => true,
			),
			'has_archive'   => $listings_slug,
			// 'has_archive' => ( $archive_page = $listing_option['listing_slug'] ) && get_post( $archive_page ) ? get_page_uri( $archive_page ) : 'listings',
			'hierarchical'  => false,
		);

		register_post_type( 'rlisting', $args );
	}

	public function resido_agencies() {
		 $listing_option     = resido_listing_option();
		$agency_details_slug = isset( $listing_option['agency_details_slug'] ) ? $listing_option['agency_details_slug'] : 'agencies';
		$agency_slug         = isset( $listing_option['agency_slug'] ) ? $listing_option['agency_slug'] : 'agencies';
		$labels              = array(
			'name'               => _x( 'Agencies', 'resido-listing' ),
			'singular_name'      => _x( 'Agency', 'resido-listing' ),
			'add_new'            => _x( 'Add New Agency', 'resido-listing' ),
			'add_new_item'       => __( 'Add Agency', 'resido-listing' ),
			'edit'               => __( 'Edit', 'resido-listing' ),
			'edit_item'          => __( 'Edit Agency', 'resido-listing' ),
			'new_item'           => __( 'New Agency', 'resido-listing' ),
			'view'               => __( 'View', 'resido-listing' ),
			'view_item'          => __( 'View Agency', 'resido-listing' ),
			'search_items'       => __( 'Search Agency', 'resido-listing' ),
			'not_found'          => __( 'No Agencies found', 'resido-listing' ),
			'not_found_in_trash' => __( 'No Agencies found', 'resido-listing' ),
			'parent'             => __( 'Parent Agency', 'resido-listing' ),
			'parent_item_colon'  => '',
			'menu_name'          => _x( 'Agencies', 'resido-listing' ),
		);

		$args = array(
			'labels'        => $labels,
			'menu_icon'     => 'dashicons-building',
			'description'   => 'Holds our Agencies specific data',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'rewrite'       => array(
				'slug'       => untrailingslashit( $agency_details_slug ),
				'with_front' => false,
				'feeds'      => true,
			),
			'has_archive'   => $agency_slug,
			'hierarchical'  => false,
		);
		register_post_type( 'ragencies', $args );
	}

	public function resido_agent() {
		$listing_option     = resido_listing_option();
		$agent_details_slug = isset( $listing_option['agent_details_slug'] ) ? $listing_option['agent_details_slug'] : 'agents';
		$agent_slug         = isset( $listing_option['agent_slug'] ) ? $listing_option['agent_slug'] : 'agents';
		$labels             = array(
			'name'               => _x( 'Agents', 'resido-listing' ),
			'singular_name'      => _x( 'Agent', 'resido-listing' ),
			'add_new'            => _x( 'Add New Agent', 'resido-listing' ),
			'add_new_item'       => __( 'Add Agent', 'resido-listing' ),
			'edit'               => __( 'Edit', 'resido-listing' ),
			'edit_item'          => __( 'Edit Agent', 'resido-listing' ),
			'new_item'           => __( 'New Agent', 'resido-listing' ),
			'view'               => __( 'View', 'resido-listing' ),
			'view_item'          => __( 'View Agent', 'resido-listing' ),
			'search_items'       => __( 'Search Agent', 'resido-listing' ),
			'not_found'          => __( 'No Agents found', 'resido-listing' ),
			'not_found_in_trash' => __( 'No Agents found', 'resido-listing' ),
			'parent'             => __( 'Parent Agent', 'resido-listing' ),
			'parent_item_colon'  => '',
			'menu_name'          => _x( 'Agents', 'resido-listing' ),
		);

		$args = array(
			'labels'        => $labels,
			'menu_icon'     => 'dashicons-admin-users',
			'description'   => 'Holds our Agencies specific data',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'rewrite'       => array(
				'slug'       => untrailingslashit( $agent_details_slug ),
				'with_front' => false,
				'feeds'      => true,
			),
			'has_archive'   => $agent_slug,
			'hierarchical'  => false,
		);
		register_post_type( 'ragents', $args );
	}

	public function resido_pricing_plan() {
		$labels = array(
			'name'               => _x( 'Pricing Plan', 'resido-listing' ),
			'singular_name'      => _x( 'Pricing Plan', 'resido-listing' ),
			'add_new'            => _x( 'Add New', 'resido-listing' ),
			'add_new_item'       => __( 'Add New Pricing Plan', 'resido-listing' ),
			'edit_item'          => __( 'Edit Pricing Plan', 'resido-listing' ),
			'new_item'           => __( 'New Pricing Plan', 'resido-listing' ),
			'all_items'          => __( 'All Pricing Plan', 'resido-listing' ),
			'view_item'          => __( 'View Pricing Plan', 'resido-listing' ),
			'search_items'       => __( 'Search Pricing Plan', 'resido-listing' ),
			'not_found'          => __( 'No products found', 'resido-listing' ),
			'not_found_in_trash' => __( 'No products found in the Trash' ),
			'parent_item_colon'  => '',
			'menu_name'          => _x( 'Pricing Plan', 'resido-listing' ),
		);

		$args = array(
			'labels'        => $labels,
			'menu_icon'     => 'dashicons-money-alt',
			'description'   => 'Holds our Pricing Plan specific data',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'has_archive'   => true,
		);
		register_post_type( 'pricing_plan', $args );
	}

	public function resido_lcpt_taxonomies() {
		$listing_option   = resido_listing_option();
		$listing_tax_slug = isset( $listing_option['listing_slug'] ) ? $listing_option['listing_slug'] : 'listings';

		$labels = array(
			'name'              => _x( 'Property Types', 'resido-listing' ),
			'singular_name'     => _x( 'Property Type', 'resido-listing' ),
			'search_items'      => __( 'Search Property Types', 'resido-listing' ),
			'all_items'         => __( 'All Property Types', 'resido-listing' ),
			'parent_item'       => __( 'Parent Property Type', 'resido-listing' ),
			'parent_item_colon' => __( 'Parent Property Type', 'resido-listing' ),
			'edit_item'         => __( 'Edit Property Type', 'resido-listing' ),
			'update_item'       => __( 'Update Property Type', 'resido-listing' ),
			'add_new_item'      => __( 'Add New Property Type', 'resido-listing' ),
			'new_item_name'     => __( 'New Property Type', 'resido-listing' ),
			'menu_name'         => __( 'Property Types', 'resido-listing' ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => $listing_tax_slug,
				'with_front' => false,
			),
			// your other args...
		);
		register_taxonomy( 'rlisting_category', 'rlisting', $args );

		$labels = array(
			'name'              => _x( 'Locations', 'resido-listing' ),
			'singular_name'     => _x( 'Location', 'resido-listing' ),
			'search_items'      => __( 'Search Location', 'resido-listing' ),
			'all_items'         => __( 'All Location', 'resido-listing' ),
			'parent_item'       => __( 'Parent Location', 'resido-listing' ),
			'parent_item_colon' => __( 'Parent Location:', 'resido-listing' ),
			'edit_item'         => __( 'Edit Location', 'resido-listing' ),
			'update_item'       => __( 'Update Location', 'resido-listing' ),
			'add_new_item'      => __( 'Add New Location', 'resido-listing' ),
			'new_item_name'     => __( 'New Location', 'resido-listing' ),
			'menu_name'         => __( 'Locations', 'resido-listing' ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => _x( 'rlisting_location', 'Location Slug', 'resido-listing' ),
				'with_front' => false,
				'feeds'      => true,
			),
		);

		register_taxonomy( 'rlisting_location', 'rlisting', $args );

		$labels = array(
			'name'              => _x( 'Property Status', 'resido-listing' ),
			'singular_name'     => _x( 'Status', 'resido-listing' ),
			'search_items'      => __( 'Search Status', 'resido-listing' ),
			'all_items'         => __( 'All Status', 'resido-listing' ),
			'parent_item'       => __( 'Parent Status', 'resido-listing' ),
			'parent_item_colon' => __( 'Parent Status:', 'resido-listing' ),
			'edit_item'         => __( 'Edit Status', 'resido-listing' ),
			'update_item'       => __( 'Update Status', 'resido-listing' ),
			'add_new_item'      => __( 'Add New Status', 'resido-listing' ),
			'new_item_name'     => __( 'New Status', 'resido-listing' ),
			'menu_name'         => __( 'Property Status', 'resido-listing' ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => _x( 'rlisting_status', 'Status Slug', 'resido-listing' ),
				'with_front' => false,
				'feeds'      => true,
			),
		);

		register_taxonomy( 'rlisting_status', 'rlisting', $args );

		$labels = array(
			'name'              => _x( 'Listing Features', 'resido-listing' ),
			'singular_name'     => _x( 'Listing Features', 'resido-listing' ),
			'search_items'      => __( 'Search Listing Features', 'resido-listing' ),
			'all_items'         => __( 'All Listing Features', 'resido-listing' ),
			'parent_item'       => __( 'Parent Listing Features', 'resido-listing' ),
			'parent_item_colon' => __( 'Parent Listing Features:', 'resido-listing' ),
			'edit_item'         => __( 'Edit Listing Features', 'resido-listing' ),
			'update_item'       => __( 'Update Listing Features', 'resido-listing' ),
			'add_new_item'      => __( 'Add New Listing Features', 'resido-listing' ),
			'new_item_name'     => __( 'New Listing Features', 'resido-listing' ),
			'menu_name'         => __( 'Listing Features', 'resido-listing' ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
			'rewrite'      => array(
				'slug'       => _x( 'rlisting_features', 'Features Slug', 'resido-listing' ),
				'with_front' => false,
				'feeds'      => true,
			),
		);

		register_taxonomy( 'rlisting_features', 'rlisting', $args );

		$labels = array(
			'name'              => _x( 'Room Place Type', 'resido-listing' ),
			'singular_name'     => _x( 'Room Place Typees', 'resido-listing' ),
			'search_items'      => __( 'Search Place Typees', 'resido-listing' ),
			'all_items'         => __( 'All Place Typees', 'resido-listing' ),
			'parent_item'       => __( 'Parent Place Typees', 'resido-listing' ),
			'parent_item_colon' => __( 'Parent Place Typees:', 'resido-listing' ),
			'edit_item'         => __( 'Edit Place Typees', 'resido-listing' ),
			'update_item'       => __( 'Update Place Typees', 'resido-listing' ),
			'add_new_item'      => __( 'Add New Place Typees', 'resido-listing' ),
			'new_item_name'     => __( 'New Place Type', 'resido-listing' ),
			'menu_name'         => __( 'Room Place Type', 'resido-listing' ),
		);

		$args = array(
			'labels'       => $labels,
			'hierarchical' => true,
		);

		register_taxonomy( 'rrooms_place_type', 'rrooms', $args );
	}
}

new RListing_CPT();
