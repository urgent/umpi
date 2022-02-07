<?php
$to = get_post_meta( get_the_ID(), 'rlisting_email', true );
return array(
	'id'             => 'general_settings',
	'title'          => esc_html__( 'General', 'resido-listing' ),
	'settings_pages' => 'resido-listings',
	'tab'            => 'general',
	'fields'         => array(

		array(
			'name'    => esc_html__( 'Subscription', 'resido-listing' ),
			'id'      => 'enable_subscription',
			'type'    => 'radio',
			'options' => array(
				'1' => esc_html__( 'Enable', 'resido-listing' ),
				'0' => esc_html__( 'Disable', 'resido-listing' ),
			),
			'std'     => '1',
			'inline'  => true,
		),
		array(
			'name'    => esc_html__( 'Pagination Style', 'resido-listing' ),
			'id'      => 'pagination_layout',
			'type'    => 'radio',
			'options' => array(
				'1' => esc_html__( 'Default', 'resido-listing' ),
				'2' => esc_html__( 'Load More', 'resido-listing' ),
			),
			'std'     => '1',
			'inline'  => true,
		),
		array(
			'name' => esc_html__( 'Currency Symbol', 'resido-listing' ),
			'id'   => 'currency_symbol',
			'type' => 'text',
			'std'  => '$',
		),

		array(
			'name'    => esc_html__( 'Currency Position', 'resido-listing' ),
			'id'      => 'currency_position',
			'type'    => 'radio',
			'options' => array(
				'1' => esc_html__( 'Left', 'resido-listing' ),
				'2' => esc_html__( 'Right', 'resido-listing' ),
				'3' => esc_html__( 'Left with space', 'resido-listing' ),
				'4' => esc_html__( 'Right with space', 'resido-listing' ),
			),
			'std'     => '1',
			'inline'  => true,
		),

		array(
			'type' => 'heading',
			'name' => __( 'Share option Settings', 'resido-listing' ),
		),
		array(
			'name' => esc_html__( 'Facebook', 'resido-listing' ),
			'id'   => 'share_facebook',
			'type' => 'checkbox',
			'std'  => true,
		),
		array(
			'name' => esc_html__( 'Twitter', 'resido-listing' ),
			'id'   => 'share_twitter',
			'type' => 'checkbox',
			'std'  => true,
		),
		array(
			'name' => esc_html__( 'LinkedIn', 'resido-listing' ),
			'id'   => 'share_linked_in',
			'type' => 'checkbox',
			'std'  => true,
		),
		array(
			'name' => esc_html__( 'Whatsapp', 'resido-listing' ),
			'id'   => 'share_whatsapp',
			'type' => 'checkbox',
		),

		array(
			'name' => esc_html__( 'Telegram', 'resido-listing' ),
			'id'   => 'share_telegram',
			'type' => 'checkbox',
		),
		array(
			'name' => esc_html__( 'VK', 'resido-listing' ),
			'id'   => 'share_vk',
			'type' => 'checkbox',
		),

		array(
			'type' => 'heading',
			'name' => __( 'Login Popup Settings', 'resido-listing' ),
		),

		array(
			'name'    => esc_html__( 'Registration On or Off', 'resido-listing' ),
			'id'      => 'registration_on_off',
			'type'    => 'radio',
			'options' => array(
				'yes' => esc_html__( 'Yes', 'resido-listing' ),
				'no'  => esc_html__( 'No', 'resido-listing' ),
			),
			'std'     => 'yes',
			'inline'  => true,
		),
		array(
			'name' => esc_html__( 'Registration Redirect URL', 'reveal-listing' ),
			'id'   => 'registration_redirect_url',
			'type' => 'text',
		),
		array(
			'name' => esc_html__( 'Login Redirect URL', 'reveal-listing' ),
			'id'   => 'login_redirect_url',
			'type' => 'text',
		),
		// [
		// 'type' => 'heading',
		// 'name' => __('Add Listing  Settings', 'resido-listing'),
		// ],

		// [
		// 'name' => esc_html__('Add Listing With Package', 'resido-listing'),
		// 'id' => 'add_listing_with_package',
		// 'type' => 'radio',
		// 'options' => array(
		// 'yes' => esc_html__('Yes', 'resido-listing'),
		// 'no' => esc_html__('No', 'resido-listing'),
		// ),
		// 'std' => 'yes',
		// 'inline' => true,
		// ],

		// [
		// 'type' => 'heading',
		// 'name' => __('Home Page Search Settings', 'resido-listing'),
		// ],

		// [
		// 'name' => esc_html__('Keywords', 'resido-listing'),
		// 'id' => 'home_keyword_search',
		// 'type' => 'select',
		// 'options' => array(
		// 'yes' => esc_html__('Yes', 'resido-listing'),
		// 'no' => esc_html__('No', 'resido-listing'),
		// ),
		// 'std' => 'yes',
		// 'inline' => true,
		// ],

		// [
		// 'name' => esc_html__('Location', 'resido-listing'),
		// 'id' => 'home_location_search',
		// 'type' => 'select',
		// 'options' => array(
		// 'yes' => esc_html__('Yes', 'resido-listing'),
		// 'no' => esc_html__('No', 'resido-listing'),
		// ),
		// 'std' => 'yes',
		// 'inline' => true,
		// ],

		// [
		// 'name' => esc_html__('Location Auto Search By Google', 'resido-listing'),
		// 'id' => 'location_auto_search',
		// 'type' => 'select',
		// 'options' => array(
		// 'yes' => esc_html__('Yes', 'resido-listing'),
		// 'no' => esc_html__('No', 'resido-listing'),
		// ),
		// 'std' => 'yes',
		// 'inline' => true,
		// ],

		array(
			'type' => 'heading',
			'name' => __( 'Other Slug settings', 'resido-listing' ),
		),

        array(
            'name' => esc_html__('Agencies archive page slug', 'resido-listing'),
            'desc' => esc_html__('This will be shown in the Agency archive url You must flush the permalink after the change.You must flush the permalink after the change. To flush the permalink goto settings => permalinks => save.', 'resido-listing'),
            'id' => 'agency_slug',
            'std' => 'agencies',
            'type' => 'text',
		),

        array(
            'name' => esc_html__('Agency single page slug', 'resido-listing'),
            'desc' => esc_html__('This will be shown in the Agency details url You must flush the permalink after the change.You must flush the permalink after the change. To flush the permalink goto settings => permalinks => save.', 'resido-listing'),
            'id' => 'agency_details_slug',
            'std' => 'agencies',
            'type' => 'text',
		),

        array(
            'name' => esc_html__('Agents archive page slug', 'resido-listing'),
            'desc' => esc_html__('This will be shown in the Agent archive url You must flush the permalink after the change.You must flush the permalink after the change. To flush the permalink goto settings => permalinks => save.', 'resido-listing'),
            'id' => 'agent_slug',
            'std' => 'agents',
            'type' => 'text',
		),

        array(
            'name' => esc_html__('Agent single page slug', 'resido-listing'),
            'desc' => esc_html__('This will be shown in the Agent details url You must flush the permalink after the change.You must flush the permalink after the change. To flush the permalink goto settings => permalinks => save.', 'resido-listing'),
            'id' => 'agent_details_slug',
            'std' => 'agents',
            'type' => 'text',
		),
	),
);
