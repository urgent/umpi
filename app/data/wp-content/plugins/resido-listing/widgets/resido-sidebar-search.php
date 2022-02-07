<?php
add_action('widgets_init', 'resido_sidebar_search');

function resido_sidebar_search()
{
    register_widget('Sidebar_Search');
}

class Sidebar_Search extends WP_Widget
{

    private $defaults = array();

    function __construct()
    {
        $this->defaults = array(
            'title'         => '',
            'bed_check_var' => '',
            'ft_check_var'  => '',
            'st_check_var'  => '',
            'listing_cate'  => '',
            'rswhere'       => '',
        );
        WP_Widget::__construct('resido-listing-search', esc_html__('Resido Listing Search', 'resido-listing'));
    }

    function update($new_instance, $old_instance)
    {
        $defaults                               = $this->defaults;
        $instance                               = $old_instance;
        $instance['title']                      = esc_attr($new_instance['title']);
        $instance['sidebar_search_keyword']     = $new_instance['sidebar_search_keyword'];
        $instance['bedroom_text']               = $new_instance['bedroom_text'];
        $instance['rswhere']                    = isset($new_instance['rswhere']) ? $new_instance['rswhere'] : '';
        $instance['bed_check_var']              = isset($new_instance['bed_check_var']) ? $new_instance['bed_check_var'] : '';
        $instance['ft_check_var']               = isset($new_instance['ft_check_var']) ? $new_instance['ft_check_var'] : '';
        $instance['st_check_var']               = isset($new_instance['st_check_var']) ? $new_instance['st_check_var'] : '';
        $instance['listing_cate']               = isset($new_instance['listing_cate']) ? $new_instance['listing_cate'] : '';
        $instance['rswhere']                    = isset($new_instance['rswhere']) ? $new_instance['rswhere'] : '';

        $this->flush_widget_cache();

        return $instance;
    }

    public function flush_widget_cache()
    {
        wp_cache_delete('resido_calculation_wid', 'widget');
    }

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        $title    = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $bedroom_text    = isset($instance['bedroom_text']) ? esc_attr($instance['bedroom_text']) : '';
        $sidebar_search_keyword    = isset($instance['sidebar_search_keyword']) ? esc_attr($instance['sidebar_search_keyword']) : 'Keywords...';
?>
        <!-- New Entry Fields for better Customization -->
        <p><label for="<?php printf($this->get_field_id('title')); ?>"><b><?php _e('Title'); ?></b></label>
            <input class="widefat" id="<?php printf($this->get_field_id('title')); ?>" name="<?php printf($this->get_field_name('title')); ?>" type="text" value="<?php printf($title); ?>" />
        </p>
        <p><label for="<?php printf($this->get_field_id('sidebar_search_keyword')); ?>"><b><?php _e('Search placeholder'); ?></b></label>
            <input class="widefat" id="<?php printf($this->get_field_id('sidebar_search_keyword')); ?>" name="<?php printf($this->get_field_name('sidebar_search_keyword')); ?>" type="text" placeholder="1,2,3,4,5" value="<?php printf($sidebar_search_keyword); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['bed_check_var'], 'on'); ?> id="<?php echo $this->get_field_id('bed_check_var'); ?>" name="<?php echo $this->get_field_name('bed_check_var'); ?>" />
            <label for="<?php echo $this->get_field_id('bed_check_var'); ?>">
                <?php echo esc_html__('Enable Bedrooms', 'resido-listing'); ?>
            </label>
        </p>
        <p><label for="<?php printf($this->get_field_id('bedroom_text')); ?>"><b><?php _e('Bedrooms'); ?></b></label>
            <input class="widefat" id="<?php printf($this->get_field_id('bedroom_text')); ?>" name="<?php printf($this->get_field_name('bedroom_text')); ?>" type="text" placeholder="1,2,3,4,5" value="<?php printf($bedroom_text); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['rswhere'], 'on'); ?> id="<?php echo $this->get_field_id('rswhere'); ?>" name="<?php echo $this->get_field_name('rswhere'); ?>" />
            <label for="<?php echo $this->get_field_id('rswhere'); ?>">
                <?php echo esc_html__('Locations', 'resido-listing'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['listing_cate'], 'on'); ?> id="<?php echo $this->get_field_id('listing_cate'); ?>" name="<?php echo $this->get_field_name('listing_cate'); ?>" />
            <label for="<?php echo $this->get_field_id('listing_cate'); ?>">
                <?php echo esc_html__('Property Types', 'resido-listing'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['st_check_var'], 'on'); ?> id="<?php echo $this->get_field_id('st_check_var'); ?>" name="<?php echo $this->get_field_name('st_check_var'); ?>" />
            <label for="<?php echo $this->get_field_id('st_check_var'); ?>">
                <?php echo esc_html__('Property Status', 'resido-listing'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['ft_check_var'], 'on'); ?> id="<?php echo $this->get_field_id('ft_check_var'); ?>" name="<?php echo $this->get_field_name('ft_check_var'); ?>" />
            <label for="<?php echo $this->get_field_id('ft_check_var'); ?>">
                <?php echo esc_html__('Features', 'resido-listing'); ?>
            </label>
        </p>



    <?php
    }
    function widget($args, $instance)
    {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        extract($args);
        $bed_check_var  = $instance['bed_check_var'] ? 'true' : 'false';
        $ft_check_var   = $instance['ft_check_var'] ? 'true' : 'false';
        $st_check_var   = $instance['st_check_var'] ? 'true' : 'false';
        $listing_cate   = $instance['listing_cate'] ? 'true' : 'false';
        $rswhere        = $instance['rswhere'] ? 'true' : 'false';
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $rkeyword = '';
        $location = '';

        if (isset($_GET['s'])) {
            $rkeyword = $_GET['s'];
        }

        if (isset($_GET['location'])) {
            $location = $_GET['location'];
        }

        $listing_option             = resido_listing_option();
        $sidebar_search_keyword     = isset($instance['sidebar_search_keyword']) ? $instance['sidebar_search_keyword'] : 'Keywords...';
        $bedroom_text               = (!empty($instance['bedroom_text'])) ? $instance['bedroom_text'] : '1,2,3,4,5';
    ?>

        <!-- Find New Property -->
        <?php
        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $keyword_value = $_GET['s'];
        } else {
            $keyword_value = null;
        }

        if (isset($_GET['listing_loc']) && !empty($_GET['listing_loc'])) {
            $listing_loc_val = $_GET['listing_loc'];
        } else {
            $listing_loc_val = null;
        }

        if (isset($_GET['listing_cate']) && !empty($_GET['listing_cate'])) {
            $listing_cate_val = $_GET['listing_cate'];
        } else {
            $listing_cate_val = null;
        }
        if (isset($_GET['rlisting_st']) && !empty($_GET['rlisting_st'])) {
            $listing_st_val = $_GET['rlisting_st'];
        } else {
            $listing_st_val = null;
        }

        if (isset($_GET['rl_bed']) && !empty($_GET['rl_bed'])) {
            $listing_bed_val = $_GET['rl_bed'];
        } else if (isset($_GET['listing_beds']) && !empty($_GET['listing_beds'])) {
            $listing_bed_val = $_GET['listing_beds'];
        } else {
            $listing_bed_val = null;
        }

        if (isset($_GET['rl_features']) && !empty($_GET['rl_features'])) {
            $rl_features_val = $_GET['rl_features'];
        } else {
            $rl_features_val = null;
        }

        if (!isset($listing_option['listing_slug'])) {
            $listing_slug = 'listings';
        } else {
            $listing_slug = $listing_option['listing_slug'];
        }

        ?>
        <!-- search Form -->
        <div class="simple-sidebar" id="filter_search" style="left:0;">
            <!-- Find New Property -->
            <form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url($listing_slug . '/?type=1')); ?>">
                <input type="hidden" name="search" value="advanced">
                <div class="sidebar-widgets">
                    <div class="search-inner p-0">
                        <div class="filter-search-box">
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <input type="text" class="form-control" value="<?php _e($keyword_value, 'resido-listing'); ?>" placeholder="<?php _e($sidebar_search_keyword, 'resido-listing'); ?>" name="s" />
                                    <i class="ti-search"></i>
                                </div>
                            </div>
                        </div>
                        <div class="filter_wraps">
                            <?php if ($rswhere != 'false') {  ?>
                                <!-- Single Search -->
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#rswhere" data-bs-toggle="collapse" aria-expanded="true" role="button" class=""><?php esc_html_e('Where', 'resido-listing') ?>
                                                <span class="selected">
                                                    <?php
                                                    if (!empty($listing_loc_val) && is_array($listing_loc_val)) {
                                                        esc_html_e(implode(", ", $listing_loc_val), 'resido-listing');
                                                    } else if (!empty($listing_loc_val) && !is_array($listing_loc_val)) {
                                                        esc_html_e($listing_loc_val, 'resido-listing');
                                                    } ?>
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="widget-boxed-body collapse show" id="rswhere" data-parent="#rswhere">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body pt-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <?php
                                                            $rlisting_location = get_terms(
                                                                array(
                                                                    'taxonomy'   => 'rlisting_location',
                                                                    'hide_empty' => false,
                                                                )
                                                            );
                                                            if (!empty($rlisting_location)) {
                                                                foreach ($rlisting_location as $key => $single) {
                                                                    if (isset($listing_loc_val)) {
                                                                        if (is_array($listing_loc_val) &&  in_array($single->slug, $listing_loc_val)) {
                                                                            $checked_point = 'checked';
                                                                        } else if ($single->slug == $listing_loc_val) {
                                                                            $checked_point = 'checked';
                                                                        } else {
                                                                            $checked_point = null;
                                                                        }
                                                                    } else {
                                                                        $checked_point = null;
                                                                    }
                                                            ?>
                                                                    <li>
                                                                        <input <?php esc_attr_e($checked_point, 'resido-listing'); ?> id="listing_loc<?php echo $key; ?>" class=" checkbox-custom" name="listing_loc[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                        <label for="listing_loc<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            if ($listing_cate != 'false') { ?>
                                <!-- Single Search -->
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#fptype" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed"><?php esc_html_e('Property Types', 'resido-listing') ?>
                                                <span class="selected">
                                                    <?php if (!empty($listing_cate_val && is_array($listing_cate_val))) {
                                                        esc_html_e(implode(", ", $listing_cate_val), 'resido-listing');
                                                    } else if (!empty($listing_cate_val) && !is_array($listing_cate_val)) {
                                                        esc_html_e($listing_cate_val, 'resido-listing');
                                                    } ?>
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="widget-boxed-body collapse" id="fptype" data-parent="#fptype">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body pt-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <?php
                                                            $rlisting_category = get_terms(
                                                                array(
                                                                    'taxonomy'   => 'rlisting_category',
                                                                    'hide_empty' => false,
                                                                )
                                                            );
                                                            if (!empty($rlisting_category)) {
                                                                foreach ($rlisting_category as $key => $single) {
                                                                    if (isset($listing_cate_val)) {
                                                                        if (is_array($listing_cate_val) && in_array($single->slug, $listing_cate_val)) {
                                                                            $checked_point = 'checked';
                                                                        } else if ($single->slug == $listing_cate_val) {
                                                                            $checked_point = 'checked';
                                                                        } else {
                                                                            $checked_point = null;
                                                                        }
                                                                    } else {
                                                                        $checked_point = null;
                                                                    }
                                                            ?>
                                                                    <li>
                                                                        <input <?php esc_attr_e($checked_point, 'resido-listing'); ?> id="listing_cate<?php echo $key; ?>" class=" checkbox-custom" name="listing_cate[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                        <label for="listing_cate<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            if ($st_check_var != 'false') { ?>
                                <!-- Single Search -->
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#fstatus" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed"><?php esc_html_e('Property Status', 'resido-listing') ?>
                                                <span class="selected">
                                                    <?php
                                                    if (!empty($listing_st_val) && is_array($listing_st_val)) {
                                                        esc_html_e(implode(", ", $listing_st_val), 'resido-listing');
                                                    } else if (!empty($listing_st_val) && !is_array($listing_st_val)) {
                                                        esc_html_e($listing_st_val, 'resido-listing');
                                                    } ?>
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="widget-boxed-body collapse" id="fstatus" data-parent="#fstatus">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body pt-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <?php
                                                            $rlisting_status = get_terms(
                                                                array(
                                                                    'taxonomy'   => 'rlisting_status',
                                                                    'hide_empty' => false,
                                                                )
                                                            );
                                                            if (!empty($rlisting_status)) {
                                                                foreach ($rlisting_status as $key => $single) {
                                                                    if (isset($listing_st_val)) {
                                                                        if (is_array($listing_st_val)) {
                                                                            if (in_array($single->slug, $listing_st_val)) {
                                                                                $checked_point = 'checked';
                                                                            }
                                                                        } else if ($single->slug == $listing_st_val) {
                                                                            $checked_point = 'checked';
                                                                        } else {
                                                                            $checked_point = null;
                                                                        }
                                                                    } else {
                                                                        $checked_point = null;
                                                                    }
                                                            ?>
                                                                    <li>
                                                                        <input <?php esc_attr_e($checked_point, 'resido-listing'); ?> id="rlisting_st<?php echo $key; ?>" class=" checkbox-custom" name="rlisting_st[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                        <label for="rlisting_st<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            if ($bed_check_var != 'false') { ?>
                                <!-- Single Search -->
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#fbedrooms" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed"><?php esc_html_e('Bedrooms', 'resido-listing') ?>
                                                <span class="selected">
                                                    <?php
                                                    if (!empty($listing_bed_val) && is_array($listing_bed_val)) {
                                                        esc_html_e(implode(", ", $listing_bed_val), 'resido-listing');
                                                    } else if (!empty($listing_bed_val) && !is_array($listing_bed_val)) {
                                                        esc_html_e($listing_bed_val, 'resido-listing');
                                                    } ?>
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="widget-boxed-body collapse" id="fbedrooms" data-parent="#fbedrooms">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body pt-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <?php
                                                            $listing_beds = explode(',', $bedroom_text);
                                                            if (!empty($listing_beds)) {
                                                                foreach ($listing_beds as $key => $single) {

                                                                    if (isset($listing_bed_val)) {
                                                                        if (is_array($listing_bed_val) && in_array($single, $listing_bed_val)) {
                                                                            $checked_point = 'checked';
                                                                        } else if ($single == $listing_bed_val) {
                                                                            $checked_point = 'checked';
                                                                        } else {
                                                                            $checked_point = null;
                                                                        }
                                                                    } else {
                                                                        $checked_point = null;
                                                                    }
                                                            ?>
                                                                    <li>
                                                                        <input <?php esc_attr_e($checked_point, 'resido-listing'); ?> id="rl_bed<?php echo $key; ?>" class=" checkbox-custom" name="rl_bed[]" type="checkbox" value="<?php echo $single; ?>">
                                                                        <label for="rl_bed<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single;
                                                                                                                                                echo esc_html__(' Bedrooms', 'resido-listing'); ?></label>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            if ($ft_check_var != 'false') { ?>
                                <!-- Single Search -->
                                <div class="single_search_boxed">
                                    <div class="widget-boxed-header">
                                        <h4>
                                            <a href="#ffeatures" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed"><?php esc_html_e('Features', 'resido-listing') ?>
                                                <span class="selected">
                                                    <?php
                                                    if (!empty($rl_features_val) && is_array($rl_features_val)) {
                                                        esc_html_e(implode(", ", $rl_features_val), 'resido-listing');
                                                    } else if (!empty($rl_features_val) && !is_array($rl_features_val)) {
                                                        esc_html_e($rl_features_val, 'resido-listing');
                                                    } ?>
                                                </span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="widget-boxed-body collapse" id="ffeatures" data-parent="#ffeatures">
                                        <div class="side-list no-border">
                                            <!-- Single Filter Card -->
                                            <div class="single_filter_card">
                                                <div class="card-body pt-0">
                                                    <div class="inner_widget_link">
                                                        <ul class="no-ul-list filter-list">
                                                            <?php
                                                            $rlisting_features = get_terms(
                                                                array(
                                                                    'taxonomy'   => 'rlisting_features',
                                                                    'hide_empty' => false,
                                                                )
                                                            );
                                                            if (!empty($rlisting_features)) {
                                                                foreach ($rlisting_features as $key => $single) {
                                                                    if (isset($rl_features_val)) {
                                                                        if (is_array($rl_features_val) && in_array($single->slug, $rl_features_val)) {
                                                                            $checked_point = 'checked';
                                                                        } else if ($single->slug == $rl_features_val) {
                                                                            $checked_point = 'checked';
                                                                        } else {
                                                                            $checked_point = null;
                                                                        }
                                                                    } else {
                                                                        $checked_point = null;
                                                                    }
                                                            ?>
                                                                    <li>
                                                                        <input <?php esc_attr_e($checked_point, 'resido-listing'); ?> id="rl_features<?php echo $key; ?>" class=" checkbox-custom" name="rl_features[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                        <label for="rl_features<?php echo $key; ?>" class="checkbox-custom-label"><?php esc_html_e($single->name, 'resido-listing'); ?></label>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="form-group filter_button">
                    <input type="submit" class="btn btn btn-theme-light-2 rounded full-width" id="searchsubmit" value="<?php _e('Search', 'resido-listing'); ?>" />
                </div>
            </form>
        </div>



<?php
        echo $args['after_widget'];
    }
}
