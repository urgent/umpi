<?php
class Settings
{

    public function __construct()
    {
        add_filter('mb_settings_pages', [$this, 'register_settings_pages']);
        add_filter('rwmb_meta_boxes', [$this, 'register_settings_fields']);
    }
    public function register_settings_pages($settings_pages)
    {
        $settings_pages['resido-listings'] = [
            'id' => 'resido-listings',
            'option_name' => 'resido_listings_options',
            'menu_title' => esc_html__('Settings', 'resido-listing'),
            'parent' => 'edit.php?post_type=rlisting',
            'tabs' => [
                'general' => esc_html__('General', 'resido-listing'),
                'map_settings' => esc_html__('Map', 'resido-listing'),
                'listings' => esc_html__('Listing', 'resido-listing'),
                // 'page_settings' => esc_html__('Single Page', 'resido-listing'),
                'listing_enquiry' => esc_html__('Listing Enquiry', 'resido-listing'),
                // 'ratting_settings' => esc_html__('Ratting', 'resido-listing'),
            ],
        ];
        return $settings_pages;
    }
    public function register_settings_fields($meta_boxes)
    {
        //$files = glob(__DIR__ . '/settings/general.php');
        // foreach ($files as $file) {
        //     //$meta_boxes[] = include $file;
        // }

        $meta_boxes[] = include __DIR__ . '/settings/general.php';
        $meta_boxes[] = include __DIR__ . '/settings/map-settings.php';
        $meta_boxes[] = include __DIR__ . '/settings/listing-setup.php';
        // $meta_boxes[] = include __DIR__ . '/settings/listing-item.php';
        $meta_boxes[] = include __DIR__ . '/settings/page-settings.php';
        $meta_boxes[] = include __DIR__ . '/settings/listing-enquiry.php';
        // $meta_boxes[] = include __DIR__ . '/settings/ratting-settings.php';
        return $meta_boxes;
    }
}
new Settings();
