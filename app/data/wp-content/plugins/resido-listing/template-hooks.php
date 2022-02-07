<?php
add_action('listing-enquiry-form', 'resido_enquiry_form');

function resido_enquiry_form()
{
    global $post;
    $to = get_post_meta(get_the_ID(), 'rlisting_email', true);
    if (empty($to)) {
        $to = get_option('admin_email');
    }

    if (!is_admin()) {
        $author_id = $post->post_author;
        $author_name = get_the_author_meta('display_name', $author_id);
    }


    if (is_admin()) { ?>
        <!-- Agent Detail -->
        <div class="sides-widget">
            <div class="sides-widget-header">
                <div class="sides-widget-details">
                    <h4><?php echo esc_html__("Resido Enquiry Widget", "resido-listing"); ?></h4>
                    <span><?php echo esc_html__("Click to edit", "resido-listing") ?></span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php } else if ($post->post_type == 'ragents') {
        if (isset($_POST['agent_cont_submit'])) {
            echo "posted";
        }
        $agent_name = $post->post_title;
        $agent_thumbnail = get_the_post_thumbnail_url(get_the_ID());
        $agent_phone = get_post_meta($post->ID, 'rlisting_agent_cell', true);
        $agent_email = get_post_meta($post->ID, 'rlisting_agent_email', true);
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

            <div id="listing-equiry-form" class="sides-widget-body simple-form">

                <form action="#" method="post">
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
                        <input type="text" name="phone" class="form-control" placeholder="<?php _e('+123456789', 'resido-listing') ?>">
                    </div>

                    <div class="form-group">
                        <label><?php _e('Description', 'resido-listing') ?></label>
                        <textarea class="form-control" required name="message" placeholder="<?php _e('I\'m interested in this property.', 'resido-listing') ?>"></textarea>
                    </div>

                    <?php wp_nonce_field('resido-enquiry-form', 'resido_enquiry'); ?>


                    <div id="message">
                    </div>

                    <button name="agent_cont_submit" type="submit" class="btn btn-black btn-md rounded full-width"><?php _e('Send Message', 'resido-listing') ?></button>

                </form>
            </div>
        </div>
    <?php } else { // owner form
    ?>
        <!-- Agent Detail -->
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

            <div id="listing-equiry-form" class="sides-widget-body simple-form">

                <form action="#" method="post">
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
                        <input type="text" name="phone" class="form-control" placeholder="<?php _e('+123456789', 'resido-listing') ?>">
                    </div>

                    <div class="form-group">
                        <label><?php _e('Description', 'resido-listing') ?></label>
                        <textarea class="form-control" required name="message" placeholder="<?php _e('I\'m interested in this property.', 'resido-listing') ?>"></textarea>
                    </div>

                    <?php wp_nonce_field('resido-enquiry-form', 'resido_enquiry'); ?>
                    <input type="hidden" name="action" value="resido_listing_enquiry">
                    <input type="hidden" name="listing_email" value="<?php echo $to; ?>">

                    <div id="message">
                    </div>

                    <button type="submit" class="btn btn-black btn-md rounded full-width"><?php _e('Send Message', 'resido-listing') ?></button>

                </form>
            </div>
        </div>
    <?php
    } // owner form

}

/**
 * Add Comment Rate field.
 */
add_action('comment_post', 'resido_comment_ratings', 10, 3);
function resido_comment_ratings($comment_id, $comment_approved, $commentdata)
{
    $rservice = $_POST['rservice'];
    $rmoney = $_POST['rmoney'];
    $rcleanliness = $_POST['rcleanliness'];
    $rlocation = $_POST['rlocation'];
    add_comment_meta($comment_id, 'rservice', $rservice);
    add_comment_meta($comment_id, 'rmoney', $rmoney);
    add_comment_meta($comment_id, 'rcleanliness', $rcleanliness);
    add_comment_meta($comment_id, 'rlocation', $rlocation);
    $comment_post_id = $commentdata['comment_post_ID'];

    $total_rate = (int) $rservice + (int) $rmoney + (int) $rcleanliness + (int) $rlocation;
    $average = ($total_rate * 100) / 4;
    $average = round($average, 1);

    $average = resido_get_average_rate($comment_post_id);
    update_post_meta($comment_post_id, 'resido_avarage_rate', $average);
}

add_filter('query_vars', 'resido_register_query_vars');

function resido_register_query_vars($vars)
{
    $vars[] = 'dashboard';
    $vars[] = 'layout';
    return $vars;
}

function resido_show_permalink($post_link, $post)
{
    if (is_object($post) && $post->post_type == 'rlisting') {
        $terms = wp_get_object_terms($post->ID, 'rlisting_category');
        if ($terms) {
            return str_replace('%rlisting_category%', $terms[0]->slug, $post_link);
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'resido_show_permalink', 1, 2);

// Add the custom columns to the book post type:
add_filter('manage_rlisting_posts_columns', 'set_custom_edit_book_columns');
function set_custom_edit_book_columns($columns)
{
    unset($columns['date']);
    unset($columns['tags']);
    $columns['category'] = __('Category', 'resido-listing');
    $columns['author'] = __('Author', 'resido-listing');
    $columns['featured'] = __('Featured', 'resido-listing');
    $columns['verified'] = __('Verified', 'resido-listing');
    $columns['package'] = __('Package', 'resido-listing');
    $columns['date'] = __('Date', 'resido-listing');
    return $columns;
}

add_action('manage_rlisting_posts_custom_column', 'custom_book_column', 10, 2);
function custom_book_column($column, $post_id)
{
    switch ($column) {

        case 'category':
            $terms = get_the_terms($post_id, 'rlisting_category');
            if ($terms && !empty($terms)) {
                echo $terms[0]->name;
            }
            break;

        case 'featured':
            $featured = get_post_meta($post_id, 'featured', true);
            if ($featured) {
                echo '<a href="javascript:void(0)" id="f_added_' . $post_id . '" class="button set-lfeatured" data-id="' . $post_id . '">
            <span class="lfeatured">Featured</span>
            </a>';
            } else {
                echo '<a href="javascript:void(0)" id="f_added_' . $post_id . '" class="button set-lfeatured" data-id="' . $post_id . '">
            <span class="as-lfeatured">Set as featured</span>
            </a>';
            }
            break;

        case 'verified':
            $verified = get_post_meta($post_id, 'varified', true);
            if ($verified) {
                echo '<a href="#" class="button set-lverified lverified" id="v_added_' . $post_id . '" data-id="' . $post_id . '">
            <span class="lverified">' . __('Verified', 'resido-listing') . '</span>
            </a>';
            } else {
                echo '<a href="#" class="button set-lverified lverified" id="v_added_' . $post_id . '"  data-id="' . $post_id . '">
            <span class="as-lverified">' . __('Verify', 'resido-listing') . '</span>
            </a>';
            }
            break;
        case 'package':
            $user_package_id = get_post_meta($post_id, 'user_package_id', true);
            if ($user_package_id) {
                if ('publish' == get_post_status($user_package_id)) {
                    echo __($user_package_id, 'resido-listing');
                } else {
                    echo __('Expired', 'resido-listing');
                }
            } else {
                echo __('Set Expired by Admin', 'resido-listing');
            }
            break;
    }
}

function category_fields_new($taxonomy)
{ // Function has one field to pass - Taxonomy ( Category in this case )
    wp_nonce_field('category_meta_new', 'category_meta_new_nonce'); // Create a Nonce so that we can verify the integrity of our data
    ?>
    <div class="form-field">
        <label for="category_fa">Font-Awesome Icon Class</label>
        <input name="category_icon" id="category_fa" type="text" value="" style="width:100%" />
        <p class="description">Enter a custom font-awesome icon - <a href="http://fontawesome.io/icons/" target="_blank">List
                of Icons</a></p>
    </div>
<?php
}
add_action('rlisting_category_add_form_fields', 'category_fields_new', 10);

/**
 * Category "Edit Term" Page - Add Additional Field(s)
 * @param Object $term
 * @param string $taxonomy
 */
function category_fields_edit($term, $taxonomy)
{ // Function has one field to pass - Term ( term object) and Taxonomy ( Category in this case )
    wp_nonce_field('category_meta_edit', 'category_meta_edit_nonce'); // Create a Nonce so that we can verify the integrity of our data
    $category_icon = get_option("{$taxonomy}_{$term->term_id}_icon"); // Get the icon if one is set already
?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_fa">Font-Awesome Icon Class</label>
        </th>
        <td>
            <input name="category_icon" id="category_fa" type="text" value="<?php echo (!empty($category_icon)) ? $category_icon : ''; ?>" style="width:100%;" />
            <!-- IF `$category_icon` is not empty, display it. Otherwise display an empty string -->
            <p class="description">Enter a custom Font-Awesome icon - <a href="http://fontawesome.io/icons/" target="_blank">List of Icons</a></p>
        </td>
    </tr>
<?php
}
add_action('rlisting_category_edit_form_fields', 'category_fields_edit', 10, 2);

/**
 * Save our Additional Taxonomy Fields
 * @param int $term_id
 */
function save_category_fields($term_id)
{

    /** Verify we're either on the New Category page or Edit Category page using Nonces **/
    /** Verify that a Taxonomy is set **/
    if (
        isset($_POST['taxonomy']) && isset($_POST['category_icon']) &&
        (isset($_POST['category_meta_new_nonce']) && wp_verify_nonce($_POST['category_meta_new_nonce'], 'category_meta_new') || // Verify our New Term Nonce
            isset($_POST['category_meta_edit_nonce']) && wp_verify_nonce($_POST['category_meta_edit_nonce'], 'category_meta_edit') // Verify our Edited Term Nonce
        )
    ) {
        $taxonomy = $_POST['taxonomy'];
        $category_icon = get_option("{$taxonomy}_{$term_id}_icon"); // Grab our icon if one exists
        if (!empty($_POST['category_icon'])) { // IF the user has entered text, update our field.
            update_option("{$taxonomy}_{$term_id}_icon", htmlspecialchars(sanitize_text_field($_POST['category_icon']))); // Sanitize our data before adding to the database
        } elseif (!empty($category_icon)) { // Category Icon IS empty but the option is set, they may not want an icon on this category
            delete_option("{$taxonomy}_{$term_id}_icon"); // Delete our option
        }
    } // Nonce Conditional
} // End Function
add_action('created_rlisting_category', 'save_category_fields');
add_action('edited_rlisting_category', 'save_category_fields');

/**
 * Essential Cleanup of our Options
 * @param int $term_id
 * @param string $taxonomy
 */
function remove_term_options($term_id, $taxonomy)
{
    delete_option("{$taxonomy}_{$term_id}_icon"); // Delete our option
}
add_action('pre_delete_term', 'remove_term_options', 10, 2);

add_action('user-dashboard-menu', 'resido_user_dashboard_menu');

function resido_user_dashboard_menu()
{
    $current_user = wp_get_current_user();
    $avatar_url = resido_get_avatar_url();
?>
    <li class="login-attri">
        <div class="btn-group account-drop">
            <button type="button" class="btn btn-order-by-filt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="<?php echo esc_url($avatar_url); ?>" class="avater-img" alt="img">
                <?php echo $current_user->display_name; ?>
            </button>
            <div class="dropdown-menu pull-right animated flipInX">
                <a href="<?php echo site_url('dashboard'); ?>"><i class="ti-dashboard"></i><?php echo esc_html__('Dashboard', 'resido-listing'); ?></a>
                <a href="<?php echo site_url('add-listing'); ?>"><i class="ti-plus"></i><?php echo esc_html__('Add Listing', 'resido-listing'); ?></a>
                <a href="<?php echo site_url('dashboard/?dashboard=agency'); ?>"><i class="ti-home"></i><?php echo esc_html__('Agency', 'resido-listing'); ?></a>
                <a href="<?php echo site_url('dashboard/?dashboard=profile'); ?>"><i class="ti-user"></i><?php echo esc_html__('My Profile', 'resido-listing'); ?></a>
                <a href="<?php echo site_url('dashboard/?dashboard=listings'); ?>"><i class="ti-layers"></i><?php echo esc_html__('My Listing', 'resido-listing'); ?></a>
                <a href="<?php echo site_url('dashboard/?dashboard=bookmarked'); ?>"><i class="ti-bookmark"></i><?php echo esc_html__('Bookmarked', 'resido-listing'); ?></a>
                <a class="active" href="<?php echo site_url('dashboard/?dashboard=changepassword'); ?>">
                    <i class="ti-unlock"></i>
                    <?php _e('Change Password', 'resido-listing'); ?>
                </a>
                <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="ti-power-off"></i>
                    <?php _e('Log Out', 'resido-listing'); ?></a>
            </div>
        </div>
    </li>
<?php

}

add_action('after_setup_theme', 'resido_remove_admin_bar');
function resido_remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function resido_user_redirect()
{
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_safe_redirect(home_url());
        exit;
    }
}
add_action('admin_init', 'resido_user_redirect');

function resido_footer_popup()
{
    echo do_shortcode('[listing-login-form]');
    echo do_shortcode('[listing-resistration-form]');
    echo do_shortcode('[listing-reset-form]');
}
add_action('wp_footer', 'resido_footer_popup');

add_filter('intermediate_image_sizes', 'resido_slider_image_sizes', 999);
function resido_slider_image_sizes($image_sizes)
{
    // size for slider
    //$slider_image_sizes = array('your_image_size_1', 'your_image_size_2');
    $slider_image_sizes = array('gallery_image_size');
    // for ex: $slider_image_sizes = array( 'thumbnail', 'medium' );
    // instead of unset sizes, return your custom size for slider image
    if (isset($_REQUEST['post_id']) && 'rlisting' === get_post_type($_REQUEST['post_id'])) {
        return $slider_image_sizes;
    }
    return $image_sizes;
}

// to create a custom size you can use this:
add_image_size('gallery_image_size', 100, 100, false); // Crop mode
add_image_size('rlisting_home_size', 332, 235, true);
add_image_size('rlisting_home_size_1', 370, 262, true);
add_image_size('rlisting_list', 289, 210, true);
add_image_size('rlisting_list_full', 439, 210, true);
add_image_size('rlisting_map', 394, 210, true);
add_image_size('rlisting_map_grid2', 480, 210, true);

function theme_xyz_header_metadata()
{

?>
    <meta name="abc" content="<?php the_title(); ?>" />
<?php

}
//add_action('wp_head', 'theme_xyz_header_metadata');
function tn_disable_visual_editor($can)
{

    if ((is_admin())) {
        return true;
    } else {
        return false;
    }
}
add_filter('user_can_richedit', 'tn_disable_visual_editor');

add_action('pre_get_posts', 'resido_users_own_attachments');
function resido_users_own_attachments($wp_query_obj)
{
    global $current_user, $pagenow;
    $is_attachment_request = ($wp_query_obj->get('post_type') == 'attachment');
    if (!$is_attachment_request)
        return;
    if (!is_a($current_user, 'WP_User'))
        return;
    if (!in_array($pagenow, array('upload.php', 'admin-ajax.php')))
        return;
    if (!current_user_can('delete_pages'))
        $wp_query_obj->set('author', $current_user->ID);
    return;
}
