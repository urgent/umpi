<?php

/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
if (!class_exists('Redux')) {
    return;
}
// This is your option name where all the Redux data is stored.
$opt_prefix = 'resido_';
$opt_name   = 'resido_options';
$args  = array();

Redux::setArgs($opt_name, $args);
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Listing Single', 'resido-listing'),
        'id'               => 'single_listing',
        'customizer_width' => '400px',
        'priority'         => '10',
        'icon'             => 'el el-cog-alt',
        'fields'           => array(
            array(
                'id'       => $opt_prefix . 'top_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Breadcrumb', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'id'       => $opt_prefix . 'top_breadcrumb_slider',
                'type'     => 'switch',
                'title'    => esc_html__('Breadcrumb Slider', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'id'       => $opt_prefix . 'title_top',
                'type'     => 'switch',
                'title'    => esc_html__('Title Top', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'title_top', '=', '1'),
                ),
                'id'       => $opt_prefix . 'title_top_img',
                'type'     => 'switch',
                'title'    => esc_html__('Featured Image as thumb', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'id'      => $opt_prefix . 'single_listing_layout',
                'type'    => 'sorter',
                'title'   => 'Single Layout',
                'desc'    => 'Organize how you want the layout to appear on the filter section',
                'options' => array(
                    'enabled'  => array(
                        'title_block'           => 'Title Block',
                        'additional'            => 'Additional',
                        'description'           => 'Description',
                        'features'              => 'Features',
                        'video'                 => 'Video',
                        'floor_plan'            => 'Floor Plan',
                        'location'              => 'Location',
                        'gallery'               => 'Gallery',
                        'rating-overview'       => 'Rating',
                        'comments-template'     => 'Comments',
                        'comments-form'         => 'Comment Form',
                    ),
                    'disabled' => array(),
                ),
            ),
            array(
                'id'       => $opt_prefix . 'single_listing_checkbox',
                'type'     => 'checkbox',
                'title'    => __('Default Collapsed section on the first load', 'redux-framework-demo'),
                //Must provide key => value pairs for multi checkbox options
                'options'  => array(
                    '1' => 'Title Block',
                    '2' => 'Additional',
                    '3' => 'Description',
                    '4' => 'Features',
                    '5' => 'Video',
                    '6' => 'Floor Plan',
                    '7' => 'Location',
                    '8' => 'Gallery',
                    '9' => 'Rating',
                    '10' => 'Comments',
                    '11' => 'Comment Form'
                ),

                //See how default has changed? you also don't need to specify opts that are 0.
                'default' => array(
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '0',
                    '5' => '0',
                    '6' => '0',
                    '7' => '0',
                    '8' => '0',
                    '9' => '0',
                    '10' => '0',
                    '11' => '0'
                )
            ),
        ),
    )
);

Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Listing Archive', 'resido-listing'),
        'id'               => 'listing_archive',
        'customizer_width' => '400px',
        'priority'         => '10',
        'icon'             => 'el el-cog-alt',
        'fields'           => array(
            array(
                'id'       => $opt_prefix . 'ar_top_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Breadcrumb', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'ar_top_breadcrumb', '=', '1'),
                ),
                'id'       => $opt_prefix . 'archive_page_title',
                'type'     => 'text',
                'title'    => esc_html__('Title', 'resido-listing'),
                'default'  => esc_html__('Property List', 'resido-listing'),
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'ar_top_breadcrumb', '=', '1'),
                ),
                'id'       => $opt_prefix . 'archive_page_subtitle',
                'type'     => 'text',
                'title'    => esc_html__('Sub Title', 'resido-listing'),
                'default'  => esc_html__('Property List With Sidebar', 'resido-listing'),
            ),
        ),
    )
);

Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Agent & Agency', 'resido-listing'),
        'id'               => 'listing_agentnagency',
        'customizer_width' => '400px',
        'priority'         => '10',
        'icon'             => 'el el-torso',
        'fields'           => array(
            array(
                'id'       => $opt_prefix . 'agent_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Agent Breadcrumb', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'agent_breadcrumb', '=', '1'),
                ),
                'id'       => $opt_prefix . 'agent_archive_page_title',
                'type'     => 'text',
                'title'    => esc_html__('Agent Archive Page Title', 'resido-listing'),
                'default'  => esc_html__('Property List', 'resido-listing'),
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'agent_breadcrumb', '=', '1'),
                ),
                'id'       => $opt_prefix . 'agent_archive_page_subtitle',
                'type'     => 'text',
                'title'    => esc_html__('Sub Title', 'resido-listing'),
                'default'  => esc_html__('Property List With Sidebar', 'resido-listing'),
            ),

            array(
                'id'       => $opt_prefix . 'agency_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Agency Breadcrumb', 'resido-listing'),
                'default'  => true,
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'agency_breadcrumb', '=', '1'),
                ),
                'id'       => $opt_prefix . 'agency_archive_page_title',
                'type'     => 'text',
                'title'    => esc_html__('Agency Archive Page Title', 'resido-listing'),
                'default'  => esc_html__('Property List', 'resido-listing'),
            ),
            array(
                'required' => array(
                    array($opt_prefix . 'agency_breadcrumb', '=', '1'),
                ),
                'id'       => $opt_prefix . 'agency_archive_page_subtitle',
                'type'     => 'text',
                'title'    => esc_html__('Sub Title', 'resido-listing'),
                'default'  => esc_html__('Property List With Sidebar', 'resido-listing'),
            ),


        ),
    )
);
