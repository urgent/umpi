<?php

return [
    'id' => 'listing_setup',
    'title' => esc_html__('Listing Setup', 'resido-listing'),
    'settings_pages' => 'resido-listings',
    'tab' => 'listings',
    'fields' => [
        [
            'name' => esc_html__('Listings archive page slug', 'resido-listing'),
            'desc' => esc_html__('This will be shown in the listing archive url, You must flush the permalink after the change.You must flush the permalink after the change. To flush the permalink goto settings => permalinks => save. Slugs must be different then listing details slug', 'resido-listing'),
            'id' => 'listing_slug',
            'std' => 'listings',
            'type' => 'text',
        ],

        [
            'name' => esc_html__('Listing single page slug', 'resido-listing'),
            'desc' => esc_html__('This will be shown in the listing details url You must flush the permalink after the change.You must flush the permalink after the change. To flush the permalink goto settings => permalinks => save. Slugs must be different then listing archive page slug', 'resido-listing'),
            'id' => 'listing_details_slug',
            'std' => 'listing',
            'type' => 'text',
        ],

        [
            'name' => esc_html__('Default View', 'resido-listing'),
            'id' => 'listing_layout_view',
            'type' => 'select',
            'options' => array(
                'grid' => __('Grid', 'resido-listing'),
                'list' => __('List', 'resido-listing'),
                'classic' => __('Classic', 'resido-listing'),
            ),
            'std' => 'grid',
        ],

        [
            'name' => esc_html__('Grid Column', 'resido-listing'),
            'id' => 'listing_grid_layout_column',
            'type' => 'select',
            'options' => array(
                'col-md-12' => __('1', 'resido-listing'),
                'col-md-6' => __('2', 'resido-listing'),
                'col-md-4' => __('3', 'resido-listing'),
            ),
            'std' => 'col-md-6',
        ],

        [
            'name' => esc_html__('List Column', 'resido-listing'),
            'id' => 'listing_list_layout_column',
            'type' => 'select',
            'options' => array(
                'col-md-12' => __('1', 'resido-listing'),
                'col-md-6' => __('2', 'resido-listing'),
                'col-md-4' => __('3', 'resido-listing'),
            ),
            'std' => 'col-md-6',
        ],

        [
            'name' => esc_html__('Posts Per Page', 'resido-listing'),
            'desc' => esc_html__('How many posts to show in archive listing', 'resido-listing'),
            'id' => 'listing_post_per_page',
            'type' => 'number',
            'min' => 2,
            'step' => 1,
            'std' => 12,
        ],

        [
            'name' => esc_html__('Order By', 'resido-listing'),
            'id' => 'listing_order_by',
            'type' => 'select',
            'options' => array(
                'date' => __('Date', 'resido-listing'),
                'ID' => __('ID', 'resido-listing'),
                'author' => __('Author', 'resido-listing'),
                'title' => __('Title', 'resido-listing'),
                'modified' => __('Modified', 'resido-listing'),
                'rand' => __('Random', 'resido-listing'),
                'comment_count' => __('Comment count', 'resido-listing'),
                'menu_order' => __('Menu order', 'resido-listing'),
            ),
            'std' => 'ID',
        ],
        [
            'name' => esc_html__('Order', 'resido-listing'),
            'id' => 'listing_order',
            'type' => 'select',
            'options' => array(
                'asc' => __('ASC', 'resido-listing'),
                'desc' => __('DESC', 'resido-listing'),

            ),
            'std' => 'desc',
        ],

        [
            'name' => esc_html__('Newsletter', 'resido-listing'),
            'id' => 'footer_newsletter',
            'type' => 'checkbox',
            'std' => true,
        ],

        [
            'type' => 'heading',
            'name' => __('Listing Sidebar Settings', 'resido-listing'),
        ],

        [
            'name' => esc_html__('Sidebar', 'resido-listing'),
            'id' => 'listing_layout_sidebar',
            'type' => 'checkbox',
            'std' => true,
        ],

        [
            'name' => esc_html__('Keywords', 'resido-listing'),
            'id' => 'sidebar_keyword_search',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],

        [
            'name' => esc_html__('Location', 'resido-listing'),
            'id' => 'sidebar_location_search',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],

        [
            'name' => esc_html__('Category', 'resido-listing'),
            'id' => 'sidebar_category_search',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],

        [
            'name' => esc_html__('Advance Features', 'resido-listing'),
            'id' => 'sidebar_advance_features_search',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],

    ],
];
