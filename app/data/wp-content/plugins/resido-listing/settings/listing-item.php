<?php

return [
    'id' => 'listing_item',
    'title' => esc_html__('Listing Item', 'resido-listing'),
    'settings_pages' => 'resido-listings',
    'tab' => 'listings',
    'fields' => [
        [
            'name' => esc_html__('Show Listing Item Price', 'resido-listing'),
            'id' => 'listing_item_price',
            'type' => 'select',
            'options' => array(
                'yes' => esc_html__('Yes', 'resido-listing'),
                'no' => esc_html__('No', 'resido-listing'),
            ),
            'std' => 'yes',
            'inline' => true,
        ],
        [
            'name' => esc_html__('Avatar Image', 'resido-listing'),
            'id' => 'listing_avatar_image',
            'type' => 'checkbox',
        ],
    ],
];
