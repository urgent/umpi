<?php
/*
==============================
Resido_Enquiry_Widget
==============================
*/

function enquiry_widget()
{
    register_widget('Resido_Enquiry_Widget');
}
add_action('widgets_init', 'enquiry_widget', 2);

class Resido_Enquiry_Widget extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array('classname' => 'resido_enquiry_widget', 'description' => __("Latest CPT's & Posts."));
        WP_Widget::__construct('resido-enquiry', __('Resido Enquiry Widget'), $widget_ops);
        $this->alt_option_name = 'resido_enquiry_widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    public function widget($args, $instance)
    {
        $cache = array();
        if (!$this->is_preview()) {
            $cache = wp_cache_get('resido_enquiry_wid', 'widget');
        }

        if (!is_array($cache)) {
            $cache = array();
        }

        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        if (isset($cache[$args['widget_id']])) {
            printf($cache[$args['widget_id']]);
            return;
        }

        ob_start();

        $title = (!empty($instance['title'])) ? $instance['title'] : __('Enquiry Widget');
        if (isset($instance['shortcode']) && $instance['shortcode']) {
            $shortcode = $instance['shortcode'];
        }
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
?>

        <?php printf($args['before_widget']);
        // Show portion
        if (isset($shortcode) && $shortcode && is_single() && get_post_type() == 'rlisting') {
            global $post;
            $author_id = $post->post_author;
            $author_name = get_the_author_meta('display_name', $author_id);
        ?>
            <div class="sides-widget">
                <div class="sides-widget-header">
                    <div class="agent-photo">
                        <?php echo resido_get_avat('60'); ?>
                    </div>
                    <div class="sides-widget-details">
                        <h4><?php echo $author_name; ?></h4>
                        <?php if (get_the_author_meta('phone', $post->post_author)) { ?>
                            <span><i class="lni-phone-handset"></i><?php echo get_the_author_meta('phone', $post->post_author); ?></span>
                        <?php } else if (resido_get_usermeta('rphone')) { ?>
                            <span><i class="lni-phone-handset"></i><?php echo resido_get_usermeta('rphone'); ?></span>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="sides-widget-body simple-form">
                    <?php echo do_shortcode($shortcode);  ?>
                </div>
            </div>
        <?php
        } else {
            do_action('listing-enquiry-form');
        }
        // Show portion
        ?>

        <?php

        printf($args['after_widget']); ?>
        <?php
        if (!$this->is_preview()) {
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set('resido_enquiry_wid', $cache, 'widget');
        } else {
            ob_end_flush();
        }
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        if (isset($new_instance['title'])) {
            $instance['title']      = strip_tags($new_instance['title']);
        }
        if (isset($new_instance['sub_title'])) {
            $instance['sub_title']  = strip_tags($new_instance['sub_title']);
        }
        if (isset($new_instance['shortcode'])) {
            $instance['shortcode']  = strip_tags($new_instance['shortcode']);
        }


        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['resido_enquiry_widget']))
            delete_option('resido_enquiry_widget');

        return $instance;
    }

    public function flush_widget_cache()
    {
        wp_cache_delete('resido_enquiry_wid', 'widget');
    }

    public function form($instance)
    {
        $title  = isset($instance['title']) ? esc_attr($instance['title']) : 'Enquiry Widget';
        $shortcode = isset($instance['shortcode']) ? esc_attr($instance['shortcode']) : '';
        ?>
        <p><label for="<?php printf($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php printf($this->get_field_id('title')); ?>" name="<?php printf($this->get_field_name('title')); ?>" type="text" value="<?php printf($title); ?>" />
        </p>
        <p><label for="<?php printf($this->get_field_id('shortcode')); ?>"><?php _e('Shortcode:'); ?></label>
            <input class="widefat" id="<?php printf($this->get_field_id('shortcode')); ?>" name="<?php printf($this->get_field_name('shortcode')); ?>" type="text" value="<?php printf($shortcode); ?>" />
        </p>
<?php
    }
}
