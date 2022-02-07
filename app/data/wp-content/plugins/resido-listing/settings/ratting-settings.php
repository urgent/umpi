<?php
return [
    'id' => 'ratting_settings',
    'title' => esc_html__('General', 'resido-listing'),
    'settings_pages' => 'resido-listings',
    'tab' => 'ratting_settings',
    'fields' => [
        [
            'name' => esc_html__('Service', 'resido-listing'),
            'id' => 'ratting_service',
            'type' => 'checkbox',
            'std' => true,
        ],
        [
            'name' => esc_html__('Price', 'resido-listing'),
            'id' => 'ratting_price',
            'type' => 'checkbox',
            'std' => true,
        ],
        [
            'name' => esc_html__('Quality', 'resido-listing'),
            'id' => 'ratting_quality',
            'type' => 'checkbox',
            'std' => true,
        ],
        [
            'name' => esc_html__('Location', 'resido-listing'),
            'id' => 'ratting_location',
            'type' => 'checkbox',
            'std' => true,
        ],

        [
            'name' => esc_html__('Average Ratting', 'resido-listing'),
            'id' => 'ratting_average_ratting',
            'type' => 'checkbox',
            'std' => true,
        ],
    ],
];
