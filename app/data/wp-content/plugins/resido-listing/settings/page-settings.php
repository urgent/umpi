<?php
return [
    'id' => 'page_set',
    'title' => esc_html__('Single Page Settings', 'resido-listing'),
    'settings_pages' => 'resido-listings',
    'tab' => 'page_settings',
    'fields' => [
        [
            'name' => esc_html__('Single Page Style', 'resido-listing'),
            'id' => 'single_page_layout',
            'type' => 'radio',
            'options' => array(
                '1' => esc_html__('Listing Single 1', 'resido-listing'),
                '2' => esc_html__('Listing Single 2', 'resido-listing'),
                '3' => esc_html__('Listing Single 3', 'resido-listing'),
            ),
            'std' => '2',
            'inline' => true,
        ],

        // [
        //     'name' => esc_html__('Show Amenities', 'resido-listing'),
        //     'id' => 'single_amenities',
        //     'type' => 'select',
        //     'options' => array(
        //         'yes' => esc_html__('Yes', 'resido-listing'),
        //         'no' => esc_html__('No', 'resido-listing'),
        //     ),
        //     'std' => 'yes',
        //     'inline' => true,
        // ],

        [
            'name' => esc_html__('Show Location', 'resido-listing'),
            'id' => 'single_location',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],

        // [
        //     'name' => esc_html__('Show Video', 'resido-listing'),
        //     'id' => 'single_video',
        //     'type' => 'select',
        //     'options' => array(
        //         'yes' => esc_html__('Yes', 'resido-listing'),
        //         'no' => esc_html__('No', 'resido-listing'),
        //     ),
        //     'std' => 'yes',
        //     'inline' => true,
        // ],

        [
            'name' => esc_html__('Show Review', 'resido-listing'),
            'id' => 'single_add_review',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],
        [
            'name' => esc_html__('Show Enquiry Form', 'resido-listing'),
            'id' => 'single_enquiry_form',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],
        [
            'name' => esc_html__('Show Listing Info', 'resido-listing'),
            'id' => 'single_listing_info',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],
        [
            'name' => esc_html__('Show Listing Tags', 'resido-listing'),
            'id' => 'single_listing_tags',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],

        // [
        //     'name' => esc_html__('Archive Style', 'resido-listing'),
        //     'id' => 'archive_layout',
        //     'type' => 'radio',
        //     'options' => array(
        //         '1' => esc_html__('Left Sidebar', 'resido-listing'),
        //         '2' => esc_html__('No Sidebar', 'resido-listing'),
        //     ),
        //     'std' => '1',
        //     'inline' => true,
        // ],

        // [
        //     'name' => esc_html__('Select a page', 'resido-listing'),
        //     'id' => 'archive_page',
        //     'type' => 'post',
        //     'post_type' => 'page',
        //     'field_type' => 'select_advanced',
        //     'placeholder' => esc_html__('Select a page', 'resido-listing'),
        //     'query_args' => array(
        //         'post_status' => 'publish',
        //         'posts_per_page' => -1,
        //     ),
        // ],
        // [
        //     'name' => esc_html__('Archive Style', 'resido-listing'),
        //     'id' => 'archive_layout',
        //     'type' => 'radio',
        //     'options' => array(
        //         '1' => esc_html__('Left Sidebar', 'resido-listing'),
        //         '2' => esc_html__('No Sidebar', 'resido-listing'),
        //     ),
        //     'std' => '1',
        //     'inline' => true,
        // ],
        // [
        //     'name' => esc_html__('Archive Layout', 'resido-listing'),
        //     'id' => 'archive_style',
        //     'type' => 'radio',
        //     'options' => array(
        //         'grid' => esc_html__('Grid', 'resido-listing'),
        //         'list' => esc_html__('List', 'resido-listing'),
        //     ),
        //     'std' => 'grid',
        //     'inline' => true,
        // ],
        // [
        //     'name' => esc_html__('Archive page Name', 'resido-listing'),
        //     'desc' => esc_html__('Name of the listing archive page.', 'resido-listing'),
        //     'id' => 'archive_name',
        //     'std' => esc_html__('Inventory', 'resido-listing'),
        //     'type' => 'text',
        // ],

        // [
        //     'name' => esc_html__('Layout Selector', 'resido-listing'),
        //     'id' => 'layout_elector',
        //     'type' => 'radio',
        //     'options' => array(
        //         '1' => esc_html__('Yes', 'resido-listing'),
        //         '0' => esc_html__('No', 'resido-listing'),
        //     ),
        //     'std' => '1',
        //     'inline' => true,
        // ],
    ],
];
