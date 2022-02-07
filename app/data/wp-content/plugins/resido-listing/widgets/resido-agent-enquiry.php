<?php
/*
==============================
Resido_Agent_Enquiry_Widget
==============================
*/

function agent_enquiry_widget()
{
    register_widget('Resido_Agent_Enquiry_Widget');
}
add_action('widgets_init', 'agent_enquiry_widget', 2);

class Resido_Agent_Enquiry_Widget extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array('classname' => 'resido_agent_agent_enquiry_widget', 'description' => __("Latest CPT's & Posts."));
        WP_Widget::__construct('resido-agent-enquiry', __('Resido Agent Enquiry Widget'), $widget_ops);
        $this->alt_option_name = 'resido_agent_agent_enquiry_widget';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    public function widget($args, $instance)
    {
        $cache = array();
        if (!$this->is_preview()) {
            $cache = wp_cache_get('resido_agent_enquiry_wid', 'widget');
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
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
?>

        <?php
        printf($args['before_widget']);
        if (is_admin()) {
        ?>

            <!-- Agent Detail -->
            <div class="sides-widget">
                <div class="sides-widget-header">
                    <div class="sides-widget-details">
                        <h4><?php echo esc_html__("Resido Agent Enquiry Widget", "resido-listing"); ?></h4>
                        <span><?php echo esc_html__("Click to edit", "resido-listing") ?></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php } else {

            global $post;
            $author_id = $post->post_author;
            $author_name        = get_the_author_meta('display_name', $author_id);
            $agent_id           = get_post_meta(get_the_ID(), 'rlisting_rlagentinfo', true);
            $agent_name         = get_the_title($agent_id);
            $agent_thumbnail    = get_the_post_thumbnail_url($agent_id);
            $agent_phone        = get_post_meta($agent_id, 'rlisting_agent_cell', true);
            $agent_email        = get_post_meta($agent_id, 'rlisting_agent_email', true);

            $to = get_post_meta(get_the_ID(), 'rlisting_email', true);
            if (isset($to) && !empty($to)) {
                $to = $to;
            } else if (empty($to) && !empty($agent_email)) {
                $to = $agent_email;
            } else {
                $to = get_option('admin_email');
            }


            if (isset($_POST['agent_enq_submit'])) {
                if (!wp_verify_nonce($_REQUEST['resido_agent_enquiry'], 'resido-agent-enquiry')) {
                    echo esc_html__('Nonce verification failed!', 'resido-listing');
                } else {
                    $subject = 'Agent Enquiry';
                    $message = "Property Name - " . $post->post_title . ' <br> <b>Contact Information</b><br> <b>Name -</b> ' . $_POST['name'] . ' <br> <b>email -</b> ' . $_POST['email'] . '<br> <b>cell -</b> ' . $_POST['phone'] . ' <br> <b>Description - </b>' . $_POST['message'];
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                    wp_mail($to, $subject, $message, $headers);
                }
            }
        ?>

            <!-- Agent Detail -->
            <div class="sides-widget">
                <div class="sides-widget-header">
                    <div class="agent-photo">
                        <img src="<?php echo $agent_thumbnail; ?>" class="author-avater-img" width="60" height="60" alt="img">
                    </div>
                    <div class="sides-widget-details">
                        <h4><?php echo $agent_name; ?></h4>
                        <?php if ($agent_phone) { ?>
                            <span><i class="lni-phone-handset"></i><?php echo $agent_phone; ?></span>
                        <?php } else if (resido_get_usermeta('rphone')) { ?>
                            <span><i class="lni-phone-handset"></i><?php echo resido_get_usermeta('rphone'); ?></span>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="listing-agent-equiry" class="sides-widget-body simple-form">
                    <form action="" method="post">
                        <input type="hidden" name="created_for" class="form-control" value="<?php echo $author_id; ?>">

                        <div class="form-group">
                            <label><?php _e('Name', 'resido-listing') ?></label>
                            <input type="text" name="name" required class="form-control" placeholder="<?php _e('Your Name', 'resido-listing') ?>">
                        </div>

                        <div class="form-group">
                            <label><?php _e('Email', 'resido-listing') ?></label>
                            <input type="email" name="email" required class="form-control" placeholder="<?php _e('Your Email', 'resido-listing') ?>">
                        </div>

                        <div class="form-group">
                            <label><?php _e('Phone No.', 'resido-listing') ?></label>
                            <input type="text" name="phone" required class="form-control" placeholder="<?php _e('+123456789', 'resido-listing') ?>">
                        </div>

                        <div class="form-group">
                            <label><?php _e('Description', 'resido-listing') ?></label>
                            <textarea class="form-control" required name="message" placeholder="<?php _e('I\'m interested in this property.', 'resido-listing') ?>"></textarea>
                        </div>

                        <?php wp_nonce_field('resido-agent-enquiry', 'resido_agent_enquiry'); ?>
                        <!--
                    <div id="message">
                        <div class="alert alert-warning" role="alert">Succesfully Sent</div>
                    </div>
                    -->
                        <button name="agent_enq_submit" type="submit" class="btn btn-black btn-md rounded full-width"><?php _e('Send Message', 'resido-listing') ?></button>
                    </form>
                </div>
            </div>
        <?php
        }
        // Show portion

        printf($args['after_widget']); ?>
        <?php
        if (!$this->is_preview()) {
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set('resido_agent_enquiry_wid', $cache, 'widget');
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
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['resido_agent_agent_enquiry_widget']))
            delete_option('resido_agent_agent_enquiry_widget');

        return $instance;
    }

    public function flush_widget_cache()
    {
        wp_cache_delete('resido_agent_enquiry_wid', 'widget');
    }

    public function form($instance)
    {
        $title  = isset($instance['title']) ? esc_attr($instance['title']) : 'Enquiry Widget';
        ?>
        <p>
            <label for="<?php printf($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php printf($this->get_field_id('title')); ?>" name="<?php printf($this->get_field_name('title')); ?>" type="text" value="<?php printf($title); ?>" />
        </p>
<?php
    }
}
