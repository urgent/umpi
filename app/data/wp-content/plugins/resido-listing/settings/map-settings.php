<?php
return [
    'id' => 'map_settings',
    'title' => esc_html__('General', 'resido-listing'),
    'settings_pages' => 'resido-listings',
    'tab' => 'map_settings',
    'fields' => [
        [
            'name' => __('Javascript Map Key', 'resido-listing'),
            'desc' => __('Please enter your Google Map API Key. Required - <b>Google Places API Web Service and Google Maps JavaScript API.</b> <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Get Your Key</a>', 'resido-listing'),
            'id' => 'j_map_key',
            'std' => '',
            'type' => 'text',
        ],
        [
            'name' => __('Zoom Level', 'resido-listing'),
            'desc' => __('Zoom Level', 'resido-listing'),
            'id' => 'listing_zoom_level',
            'std' => 9,
            'type' => 'number',
        ],
        [
            'name' => __('Default Center Latitude', 'resido-listing'),
            'desc' => __('Center Latitude', 'resido-listing'),
            'id' => 'listing_center_latitude',
            'std' => '40.7',
            'type' => 'text',
        ],
        [
            'name' => __('Default Center Longitude', 'resido-listing'),
            'desc' => __('Center Longitude', 'resido-listing'),
            'id' => 'listing_center_longitude',
            'std' => '-73.87',
            'type' => 'text',
        ],
        [
            'name'  => __('GPS Location', 'resido-listing'),
            'desc' => __('Enable of Disable GPS Location on Map', 'resido-listing'),
            'id'    => 'listing_gps_loc_en',
            'type'  => 'radio',
            'options' => array(
                '1'   => __('Enable', 'resido-listing'),
                '0'  => __('Disable', 'resido-listing'),
            ),
        ],
        [
            'name'  => __('Map on Archive', 'resido-listing'),
            'desc'  => __('Choose Archive Page map Location Layout', 'resido-listing'),
            'id'    => 'map_layout',
            'type'  => 'radio',
            'options' => array(
                '1' => __('Enable', 'resido-listing'),
                '0' => __('Disable', 'resido-listing'),
            ),
        ],
    ],
];
