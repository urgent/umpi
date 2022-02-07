<?php

/**
 * The RListing_CPT handler class
 */
class RListing_CPT_Meta
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        add_filter('rwmb_meta_boxes', [$this, 'rlisting_register_post_meta_box']);
    }

    /**
     * Register meta boxes
     *
     * Remember to change "your_prefix" to actual prefix in your project
     *
     * @return void
     */
    function rlisting_register_post_meta_box($meta_boxes)
    {
        global $wp_registered_sidebars;
        $listing_option = get_option('resido_listings_options');

        $j_map_key = 'AIzaSyAXMag1X6n9N1AmY2DX6PrNL7dhoxDkE5w';
        if (isset($listing_option['j_map_key']) && !empty($listing_option['j_map_key'])) {
            $j_map_key = $listing_option['j_map_key'];
        }
        //$resido_option = resido_get_options();
        /**
         * prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */
        // Better has an underscore as last sign
        $prefix = 'rlisting_';
        $sidebars = array();
        foreach ($wp_registered_sidebars as $key => $value) {
            $sidebars[$key] = $value['name'];
        }

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-rlisting-expire',
            'title' => esc_html__('Listing Expire', 'resido-listing'),
            'pages' => array(
                'rsubscription',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                array(
                    'name' => esc_html__('Set Expire Date', 'resido-listing'),
                    'id' => $prefix . 'expire',
                    'type' => 'datetime',
                    // Datetime picker options.
                    // For date options, see here http://api.jqueryui.com/datepicker
                    // For time options, see here http://trentrichardson.com/examples/timepicker/
                    'js_options' => array(
                        'stepMinute' => 15,
                        'showTimepicker' => true,
                        'controlType' => 'select',
                        'showButtonPanel' => false,
                        'oneLine' => true,
                    ),
                    // Display inline?
                    'inline' => false,
                    // Save value as timestamp?
                    'timestamp' => false,
                ),
            ),

        );

        // Get Year List
        $this_year = date('Y');
        $year_list['1980'] = '1980';
        for ($i = 1981; $i <= $this_year; $i++) {
            $year_list[$i] = $i;
        }
        // Get Year List

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-basic-information',
            'title' => esc_html__('Basic Information', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Address field.
                array(
                    'id' => $prefix . 'sale_or_rent',
                    'name' => __('Sale or Rent Price(Only Digits)', 'resido-listing'),
                    'type' => 'text',
                    'std' => '5,000',
                    'desc'  => 'Example:2000',
                    'columns' => 3,
                ),

                array(
                    'id' => $prefix . 'price_postfix',
                    'name' => __('Price Postfix', 'resido-listing'),
                    'type' => 'text',
                    'std' => __('Monthly', 'resido-listing'),
                    'desc'  => 'Example : Monthly',
                    'columns' => 3,
                ),

                array(
                    'id' => $prefix . 'area_size',
                    'name' => __('Area Size', 'resido-listing'),
                    'type' => 'text',
                    'std' => '200',
                    'desc'  => 'Example:200',
                    'columns' => 3,
                ),

                array(
                    'id' => $prefix . 'area_size_postfix',
                    'name' => __('Area Size Postfix', 'resido-listing'),
                    'type' => 'text',
                    'std' => 'sqft',
                    'desc'  => 'Example: sqft',
                    'columns' => 3,
                ),

                array(
                    'id' => $prefix . 'bedrooms',
                    'name' => __('Bedroom', 'resido-listing'),
                    'type' => 'text',
                    'std' => '3',
                    'columns' => 3,

                ),

                array(
                    'id' => $prefix . 'bathrooms',
                    'name' => __('Bath Room', 'resido-listing'),
                    'type' => 'text',
                    'std' => '4',
                    'columns' => 3,
                ),

                array(
                    'id' => $prefix . 'garage',
                    'name' => __('Garage', 'resido-listing'),
                    'type' => 'text',
                    'std' => '2',
                    'columns' => 3,
                ),

                array(
                    'name' => __('Build Year', 'resido-listing'),
                    'id' => $prefix . 'built_year',
                    'type' => 'select',
                    // Array of 'value' => 'Label' pairs
                    'options' => $year_list,
                    // Allow to select multiple value?
                    'multiple' => false,
                    // Placeholder text
                    'placeholder' => 'Select Year',
                    // Display "Select All / None" button?
                    'select_all_none' => false,
                    'columns' => 3,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-location-information',
            'title' => esc_html__('Location Information', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                // array(
                //     'name' => 'Country',
                //     'id' => $prefix . 'country',
                //     'type' => 'select_advanced',
                //     'options' => resido_get_country_list_by_location(),
                //     'columns' => 3,
                // ),
                // array(
                //     'name' => 'City',
                //     'id' => $prefix . 'city',
                //     'type' => 'select_advanced',
                //     'options' => resido_get_country_list_city(),
                //     'columns' => 3,
                // ),
                //Address field.
                array(
                    'id' => $prefix . 'latitude',
                    'name' => 'Latitude',
                    'type' => 'text',
                    'columns' => 3,
                ),
                //Address field.
                array(
                    'id' => $prefix . 'longitude',
                    'name' => 'Longitude',
                    'type' => 'text',
                    'columns' => 3,
                ),
                //Address field.
                array(
                    'id' => $prefix . 'address',
                    'name' => __('Property Address', 'resido-listing'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                //Map field. will be replace by dynamic api key from settings
                array(
                    'id' => $prefix . 'map_coordinates',
                    'name' => 'Map',
                    'type' => 'map',
                    //Default location: 'latitude,longitude[,zoom]' (zoom is optional)
                    'std' => '-6.233406,-35.049906,15',
                    //Address field ID
                    'address_field' => $prefix . 'address',
                    //Google API key
                    'api_key' => $j_map_key,
                ),
                array(
                    'id' => $prefix . 'map_iframe',
                    'name' => __('Google Map Iframe', 'resido-listing'),
                    'sanitize_callback' => 'none',
                    'type' => 'textarea',
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-rlisting',
            'title' => esc_html__('Property Gallery Images', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                array(
                    'id' => $prefix . 'gallery-image',
                    'name' => esc_html__('Gellary Image', 'resido-listing'),
                    'type' => 'image_advanced',
                    // Delete image from Media Library when remove it from post meta?
                    // Note: it might affect other posts if you use same image for multiple posts
                    'force_delete' => false,
                    // Maximum image uploads.
                    // 'max_file_uploads' => 20,
                    // Do not show how many images uploaded/remaining.
                    'max_status' => 'false',
                    // Image size that displays in the edit page. Possible sizes small,medium,large,original
                    'image_size' => 'thumbnail',
                ),

                array(
                    'id' => $prefix . 'avarage_rate',
                    'name' => esc_html__('hidden', 'resido-listing'),
                    'type' => 'hidden',
                    'std' => '1',
                    'columns' => 3,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-video-information',
            'title' => esc_html__('Property Video', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                array(
                    'id' => $prefix . 'videolink',
                    'name' => esc_html__('URL', 'resido-listing'),
                    'desc' => 'Use one of the link or iFrame field for the video. Use url for opening in new tab and iframe for showing the video in the same page',
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'id' => $prefix . 'videoiframe',
                    'name' => esc_html__('Embed Iframe for the video', 'resido-listing'),
                    'sanitize_callback' => 'none',
                    'type' => 'textarea',
                    'columns' => 6,
                ),
                array(
                    'type' => 'single_image',
                    'name' => esc_html__('image', 'resido-listing'),
                    'id'   => $prefix . 'v_image',
                    'columns' => 12,
                ),

            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-floor-plan',
            'title' => esc_html__('Floor Plan', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                array(
                    'id' => $prefix . 'flor_plan',
                    // Group field
                    'type' => 'group',
                    // Clone whole group?
                    'clone' => true,
                    // Drag and drop clones to reorder them?
                    'sort_clone' => true,
                    // Sub-fields
                    'fields' => array(
                        array(
                            'name' => esc_html__('Floor Title', 'resido-listing'),
                            'id' => $prefix . 'floor_title',
                            'type' => 'text',
                            'columns' => 3,
                        ),

                        array(
                            'name' => esc_html__('Floor Size', 'resido-listing'),
                            'id' => $prefix . 'floor_size',
                            'type' => 'text',
                            'columns' => 3,
                        ),

                        array(
                            'name' => esc_html__('Size Postfix', 'resido-listing'),
                            'id' => $prefix . 'size_postfix',
                            'type' => 'text',
                            'columns' => 3,
                        ),

                        array(
                            'type' => 'single_image',
                            'name' => esc_html__('Image', 'resido-listing'),
                            'id'   => $prefix . 'floor_image',
                        ),
                    ),
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-short-details',
            'title' => esc_html__('Additionals Details', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                array(
                    'id' => $prefix . 'short_details',
                    // Group field
                    'type' => 'group',
                    // Clone whole group?
                    'clone' => true,
                    // Drag and drop clones to reorder them?
                    'sort_clone' => true,
                    // Sub-fields
                    'fields' => array(
                        array(
                            'id' => $prefix . 'short_title',
                            'type' => 'text',
                            'desc'  => 'Title',
                            'columns' => 4,
                        ),

                        array(
                            'id' => $prefix . 'short_value',
                            'type' => 'text',
                            'desc'  => 'Value',
                            'columns' => 4,
                        ),
                    ),
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-agent-contact',
            'title' => esc_html__('Agent Contact', 'resido-listing'),
            'pages' => array(
                'rlisting',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                array(
                    'id' => $prefix . 'rlname',
                    'name' => esc_html__('Name', 'resido-listing'),
                    'type' => 'text',
                    'columns' => 2,
                ),
                array(
                    'id' => $prefix . 'email',
                    'name' => esc_html__('Email', 'resido-listing'),
                    'type' => 'email',
                    'columns' => 2,
                ),
                array(
                    'id' => $prefix . 'phone',
                    'name' => esc_html__('Phone', 'resido-listing'),
                    'type' => 'text',
                    'columns' => 2,
                ),
                array(
                    'id' => $prefix . 'rlagencyinfo',
                    'name' => esc_html__('Agency info', 'resido-listing'),
                    'type' => 'text',
                    'columns' => 2,
                ),
                array(
                    'id' => $prefix . 'rlagentinfo',
                    'name' => esc_html__('Agent info', 'resido-listing'),
                    'type' => 'text',
                    'columns' => 2,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-rlisting',
            'title' => esc_html__('Pricing Plan', 'resido-listing'),
            'pages' => array(
                'pricing_plan',
            ),
            'context' => 'after_title',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(

                array(
                    'id' => $prefix . 'bg_type',
                    'columns' => 2,
                    'name' => esc_html__('Bacground Type', 'resido-listing'),
                    'std' => 'lni-layers',
                    'type'            => 'select',
                    // Array of 'value' => 'Label' pairs
                    'options'         => array(
                        'basic-pr'       => 'basic',
                        'platinum-pr'       => 'platinum',
                        'standard-pr'       => 'standard',
                    ),
                    // Allow to select multiple value?
                    'multiple'        => false,
                ),

                array(
                    'id' => '_price',
                    'columns' => 2,
                    'name' => esc_html__('Price', 'resido-listing'),
                    'type' => 'text',
                ),


                array(
                    'id' => $prefix . 'expire',
                    'columns' => 2,
                    'name' => esc_html__('Duration', 'resido-listing'),
                    'type' => 'number',
                    'desc' => 'Numbers of Days Submission will valid.',
                ),

                array(
                    'id' => $prefix . 'list_subn_limit',
                    'columns' => 3,
                    'name' => esc_html__('Listing Submission Limit', 'resido-listing'),
                    'type' => 'text',
                    'desc' => 'Numbers of listing who subscribe for this plan can submit.',
                ),

                array(
                    'id' => $prefix . 'pricing_custom_url',
                    'columns' => 3,
                    'name' => esc_html__('Pricing Custom URL', 'resido-listing'),
                    'type' => 'text',
                ),

            ),
        );

        $meta_boxes[] = array(
            'title'      => esc_html__('Featured Image', 'resido-listing'),
            'taxonomies' => 'rlisting_location', // List of taxonomies. Array or string
            'fields' => array(
                array(
                    'id'   => 'custom_meta_img',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ),
            ),
        );

        // Agency Meta

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-resido-agency-details',
            'title' => esc_html__('Agency Details', 'resido-listing'),
            'pages' => array(
                'ragencies',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Address field.
                array(
                    'id' => $prefix . 'agency_address',
                    'name' => esc_html__('Address', 'resido-listing'),
                    'type' => 'text',
                    'std' => '3599 Huntz Lane',
                    'columns' => 4,
                ),
                //Cell field.
                array(
                    'id' => $prefix . 'agency_cell',
                    'name' => esc_html__('Cell', 'resido-listing'),
                    'type' => 'text',
                    'std' => '91 123 456 7859',
                    'columns' => 4,
                ),
                //Email field.
                array(
                    'id' => $prefix . 'agency_email',
                    'name' => esc_html__('Email', 'resido-listing'),
                    'type' => 'text',
                    'std' => 'email@email.com',
                    'columns' => 4,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-resido-social-info',
            'title' => esc_html__('Social Information', 'resido-listing'),
            'pages' => array(
                'ragencies',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Social Fields
                array(
                    'id' => $prefix . 'agency_social',
                    'type' => 'textarea',
                    'columns' => 12,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-resido-agency',
            'title' => esc_html__('Agency Information', 'resido-listing'),
            'pages' => array(
                'ragencies',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Agency Information.
                array(
                    'id' => $prefix . 'agency_information',
                    'type' => 'textarea',
                    'columns' => 12,
                ),
            ),
        );

        // Agent Meta

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-resido-agent-details',
            'title' => esc_html__('Agent Details', 'resido-listing'),
            'pages' => array(
                'ragents',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Address field.
                array(
                    'id' => $prefix . 'agent_address',
                    'name' => esc_html__('Address', 'resido-listing'),
                    'type' => 'text',
                    'std' => '3599 Huntz Lane',
                    'columns' => 3,
                ),
                //Cell field.
                array(
                    'id' => $prefix . 'agent_cell',
                    'name' => esc_html__('Cell', 'resido-listing'),
                    'type' => 'text',
                    'std' => '+91 123 456 7859',
                    'columns' => 3,
                ),
                //Email field.
                array(
                    'id' => $prefix . 'agent_email',
                    'name' => esc_html__('Email', 'resido-listing'),
                    'type' => 'text',
                    'std' => 'email@email.com',
                    'columns' => 3,
                ),
                //Agency field.
                array(
                    'id' => $prefix . 'parent_agency',
                    'name' => esc_html__('Agency', 'resido-listing'),
                    'type' => 'text',
                    'columns' => 3,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-resido-social-info',
            'title' => esc_html__('Social Information', 'resido-listing'),
            'pages' => array(
                'ragents',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Social Fields
                array(
                    'id' => $prefix . 'agent_social',
                    'type' => 'textarea',
                    'columns' => 12,
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => 'framework-meta-box-resido-agent',
            'title' => esc_html__('Agent Information', 'resido-listing'),
            'pages' => array(
                'ragents',
            ),
            'context' => 'normal',
            'priority' => 'high',
            'tab_style' => 'left',
            'fields' => array(
                //Agent Information.
                array(
                    'id' => $prefix . 'agent_information',
                    'type' => 'textarea',
                    'columns' => 12,
                ),
            ),
        );

        return $meta_boxes;
    }
}

new RListing_CPT_Meta();
