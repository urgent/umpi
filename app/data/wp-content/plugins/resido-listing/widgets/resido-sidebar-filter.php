<?php
add_action('widgets_init', 'resido_sidebar_filter');

function resido_sidebar_filter()
{
    register_widget('Sidebar_Filter');
}

class Sidebar_Filter extends WP_Widget
{

    private $defaults = array();

    function __construct()
    {
        $this->defaults = array(
            'title'             => '',
            'your_checkbox_var' => '',
            'bedroom_text' => '',
        );
        WP_Widget::__construct('resido-listing-filter', esc_html__('Resido Listing Filter', 'resido-listing'));
    }

    function update($new_instance, $old_instance)
    {
        $defaults                      = $this->defaults;
        $instance                      = $old_instance;
        if (isset($new_instance['title'])) {
            $instance['title']             = esc_attr($new_instance['title']);
        }
        if (isset($new_instance['your_checkbox_var'])) {
            $instance['your_checkbox_var'] = $new_instance['your_checkbox_var'];
        }
        if (isset($new_instance['bedroom_text'])) {
            $instance['bedroom_text']      = $new_instance['bedroom_text'];
        }
        return $instance;
    }

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        $title    = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $bedroom_text    = isset($instance['bedroom_text']) ? esc_attr($instance['bedroom_text']) : '';
?>
        <!-- New Entry Fields for better Customization -->
        <p><label for="<?php printf($this->get_field_id('title')); ?>"><b><?php _e('Title'); ?></b></label>
            <input class="widefat" id="<?php printf($this->get_field_id('title')); ?>" name="<?php printf($this->get_field_name('title')); ?>" type="text" value="<?php printf($title); ?>" />
        </p>
        <p><label for="<?php printf($this->get_field_id('bedroom_text')); ?>"><b><?php _e('Bedrooms'); ?></b></label>
            <input class="widefat" id="<?php printf($this->get_field_id('bedroom_text')); ?>" name="<?php printf($this->get_field_name('bedroom_text')); ?>" type="text" value="<?php printf($bedroom_text); ?>" />
        </p>
        <!-- New Entry Fields for better Customization -->
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['your_checkbox_var'], 'on'); ?> id="<?php echo $this->get_field_id('your_checkbox_var'); ?>" name="<?php echo $this->get_field_name('your_checkbox_var'); ?>" />
            <label for="<?php echo $this->get_field_id('your_checkbox_var'); ?>">
                <?php echo esc_html__('Label of your checkbox variable', 'resido-listing'); ?>
            </label>
        </p>
    <?php
    }
    function widget($args, $instance)
    {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        extract($args);
        $your_checkbox_var = $instance['your_checkbox_var'] ? 'true' : 'false';
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

        $listing_option                  = resido_listing_option();
        $sidebar_keyword_search          = isset($listing_option['sidebar_keyword_search']) ? $listing_option['sidebar_keyword_search'] : 'yes';
    ?>
        <div class="simple-sidebar sm-sidebar" id="filter_search" style="left:0;">

            <div class="search-sidebar_header">
                <h4 class="ssh_heading"><?php echo esc_html__('Close Filter', 'resido-listing'); ?></h4>
                <button onclick="closeFilterSearch()" class="w3-bar-item w3-button w3-large"><i class="ti-close"></i></button>
            </div>
            <!-- Find New Property -->
            <div class="sidebar-widgets">
                <div class="search-inner p-0">
                    <div class="filter-search-box">
                        <?php
                        if ($sidebar_keyword_search == 'yes') {
                        ?>
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <input type="text" class="form-control" value="<?php echo $rkeyword; ?>" name="s" id="name" placeholder="<?php _e('Search by space name…', 'resido-listing'); ?>">
                                    <i class="ti-search"></i>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="filter_wraps">
                        <!-- Single Search -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4>
                                    <a href="#where" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Where<span class="where-s selected"></span></a>
                                </h4>
                            </div>
                            <div class="widget-boxed-body collapse" id="where" data-parent="#where">
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
                                                    ?>
                                                            <li>
                                                                <input id="rlisting_loc<?php echo $key; ?>" class="rlisting_location checkbox-custom" name="rlisting_location[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                <label for="rlisting_loc<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
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
                        <!-- Single Search -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4>
                                    <a href="#fptype" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Property Types<span class="fptype-s selected"></span></a>
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
                                                    ?>
                                                            <li>
                                                                <input id="rlisting_cate<?php echo $key; ?>" class="rlisting_category checkbox-custom" name="rlisting_category[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                <label for="rlisting_cate<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
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
                        <!-- Single Search -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#fstatus" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Property Status<span class="fstatus-s selected"></span></a></h4>
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
                                                    ?>
                                                            <li>
                                                                <input id="rlisting_stat<?php echo $key; ?>" class="rlisting_status checkbox-custom" name="rlisting_status[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                <label for="rlisting_stat<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
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
                        <!-- Single Search -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#fbedrooms" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">BedRooms<span class="fbedrooms-s selected"></span></a></h4>
                            </div>
                            <div class="widget-boxed-body collapse" id="fbedrooms" data-parent="#fbedrooms">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list filter-list">
                                                    <?php
                                                    if (!function_exists('rlisting_get_meta_list')) {
                                                        function rlisting_get_meta_list($attr)
                                                        {
                                                            $all_post_ids = get_posts( // Get all post of rlisting
                                                                array(
                                                                    'fields'          => 'ids',
                                                                    'posts_per_page'  => -1,
                                                                    'post_type' => 'rlisting'
                                                                )
                                                            );
                                                            $meta_val_arr = array(); //assign null array variable
                                                            foreach ($all_post_ids as $key => $post_id) { // get every meta value from all post id
                                                                $meta_price = get_post_meta(
                                                                    $post_id,
                                                                    $attr,
                                                                    true
                                                                );
                                                                array_push($meta_val_arr, $meta_price);
                                                            }
                                                            $sort_meta_val_arr = array_unique($meta_val_arr);
                                                            sort($sort_meta_val_arr); // sort the sort_meta_val_arr value
                                                            return $sort_meta_val_arr;
                                                        }
                                                    }
                                                    $rlisting_bedval = rlisting_get_meta_list('rlisting_bedrooms');
                                                    if (!empty($rlisting_bedval)) {
                                                        foreach ($rlisting_bedval as $key => $single) {
                                                    ?>
                                                            <li>
                                                                <input id="rlisting_bedval<?php echo $key; ?>" class="rlisting_bedval checkbox-custom" name="rlisting_bedval[]" type="checkbox" value="<?php echo $single; ?>">
                                                                <label for="rlisting_bedval<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single; ?> Bedrooms</label>
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
                        <!-- Single Search -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#ffeatures" data-bs-toggle="collapse" aria-expanded="false" role="button" class="collapsed">Features<span class="ffeatures-s selected"></span></a></h4>
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
                                                    ?>
                                                            <li>
                                                                <input id="rlisting_features<?php echo $key; ?>" class="rlisting_features checkbox-custom" name="rlisting_features[]" type="checkbox" value="<?php echo $single->slug; ?>">
                                                                <label for="rlisting_features<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
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

                    </div>

                </div>
            </div>
        </div>
        <!-- Sidebar End -->
<?php
        echo $args['after_widget'];
    }
}
