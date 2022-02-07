<?php

return [
    'id' => 'listing_enquiry',
    'title' => esc_html__('Listing Enquiry Message', 'resido-listing'),
    'settings_pages' => 'resido-listings',
    'tab' => 'listing_enquiry',
    'fields' => [

        [
            'name' => esc_html__('Recipient Email', 'resido-listing'),
            'type' => 'heading',
            'desc' => 'Recipient Email is Listing Business Email. Default is admin email.',
        ],

        [
            'name' => esc_html__('Message Subject', 'resido-listing'),
            'id' => 'listing_message_subject',
            'type' => 'text',
            'std' => 'Listing Message',
        ],


    ],
];
