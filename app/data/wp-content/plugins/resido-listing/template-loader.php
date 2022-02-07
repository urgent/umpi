<?php
class TemplateLoader
{

    public function __construct()
    {
        add_filter('template_include', [$this, 'template_include']);
        add_filter('theme_page_templates', [$this, 'resido_dashboard_template_to_select'], 10, 4);
        add_filter('theme_page_templates', [$this, 'resido_listing_page_template'], 10, 4);
    }

    public function template_include($template)
    {
        global $post;
        $file = '';
        if (is_single() && get_post_type() == 'rlisting') {
            $theme_files = array('single-rlisting.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/single-rlisting.php';
            }
        }

        if (is_single() && get_post_type() == 'ragencies') {
            $theme_files = array('agency.php');
            $exists_in_theme = locate_template($theme_files, false);
            echo $exists_in_theme;
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/agency/agency.php';
            }
        }

        if (is_post_type_archive('ragencies')) {
            $theme_files = array('agencies.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/agency/agencies.php';
            }
        }

        if (is_post_type_archive('rlisting')) {
            $theme_files = array('archive-rlisting.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/archive-rlisting.php';
            }
        }

        if (is_post_type_archive('ragents')) {
            $theme_files = array('archive-agent.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/agency/archive-agent.php';
            }
        }

        if (is_single() && get_post_type() == 'ragents') {
            $theme_files = array('archive-agent.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/agency/single-agent.php';
            }
        }

        if (is_author()) {
            $theme_files = array('author.php');
            $exists_in_theme = locate_template($theme_files, false);
            if ($exists_in_theme != '') {
                return $exists_in_theme;
            } else {
                return plugin_dir_path(__FILE__) . '/templates/author.php';
            }
        }

        if (is_archive() && get_post_type($post) == 'rlisting') {
            return plugin_dir_path(__FILE__) . '/templates/cat-rlisting.php';
        }

        if (get_page_template_slug() === 'dashboard.php') {
            if ($theme_file = locate_template(array('dashboard.php'))) {
                $template = $theme_file;
            } else {
                $template = plugin_dir_path(__FILE__) . 'templates/dashboard.php';
            }
        }

        if (get_page_template_slug() === 'rlisting-page.php') {
            if ($theme_file = locate_template(array('rlisting-page.php'))) {
                $template = $theme_file;
            } else {
                $template = plugin_dir_path(__FILE__) . 'templates/rlisting-page.php';
            }
        }

        return $template;
    }

    function resido_halp_map_add_template_to_select($post_templates, $wp_theme, $post, $post_type)
    {
        // Add custom template named template-custom.php to select dropdown
        $post_templates['half-map-listing.php'] = __('Half Map Listing', 'resido-listing');
        return $post_templates;
    }

    function resido_dashboard_template_to_select($post_templates, $wp_theme, $post, $post_type)
    {
        // Add custom template named template-custom.php to select dropdown
        $post_templates['dashboard.php'] = __('Dashboard', 'resido-listing');
        return $post_templates;
    }

    function resido_listing_page_template($post_templates, $wp_theme, $post, $post_type)
    {
        // Add custom template named template-custom.php to select dropdown
        $post_templates['rlisting-page.php'] = __('Listing Page', 'resido-listing');
        return $post_templates;
    }
}
new TemplateLoader();
