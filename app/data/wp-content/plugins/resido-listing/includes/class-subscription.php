<?php

/**
 * The Resido_Order_CPT handler class
 */
class Resido_Order_CPT
{

  /**
   * Initialize the class
   */
  function __construct()
  {
    add_action('init', [$this, 'register']);
  }

  public function register()
  {

    $labels = array(
      'name' => _x('Subscription', 'resido-listing'),
      'singular_name' => _x('Subscription', 'resido-listing'),
      'add_new' => _x('Add New', 'resido-listing'),
      'add_new_item' => __('Add New Subscription'),
      'edit_item' => __('Edit Subscription'),
      'new_item' => __('New Subscription'),
      'all_items' => __('All Subscription'),
      'view_item' => __('View Subscription'),
      'search_items' => __('Search Subscription'),
      'not_found' => __('No products found'),
      'not_found_in_trash' => __('No products found in the Trash'),
      'parent_item_colon' => '',
      'menu_name' => 'Subscription',
    );

    $args = array(
      'labels' => $labels,
      'description' => 'Holds our Subscription Plan specific data',
      'public' => true,
      'menu_position' => 5,
      'supports' => '',
      'has_archive' => false,
      'capability_type' => 'post',
      'capabilities' => array(
        'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
      ),
      'map_meta_cap' => true, // Set to `false`, if users are not allowed to edit/delete existing posts
    );

    register_post_type('rsubscription', $args);
  }
}

new Resido_Order_CPT();

add_filter('post_row_actions', 'remove_row_actions', 10, 1);
function remove_row_actions($actions)
{
  if (get_post_type() === 'rsubscription')
    unset($actions['view']);
  return $actions;
}

// Add the custom columns to the book post type:
add_filter('manage_rsubscription_posts_columns', 'rsubscription_custom_edit_columns');
function rsubscription_custom_edit_columns($columns)
{

  unset($columns['title']);
  unset($columns['date']);
  $columns['id'] = __('Subscription', 'resido-listing');
  $columns['status'] = __('Status', 'resido-listing');
  $columns['plan'] = __('	Plan', 'resido-listing');
  $columns['package_id'] = __('	Package Id', 'resido-listing');
  $columns['expire'] = __('	Expire', 'resido-listing');
  $columns['date'] = __('Active Date', 'resido-listing');
  return $columns;
}

add_action('manage_rsubscription_posts_custom_column', 'rsubscription_custom_book_column', 10, 2);
function rsubscription_custom_book_column($column, $post_id)
{

  switch ($column) {
    case 'id';
      echo '<div class="tips">';
      echo '<a href="' . admin_url('post.php?post=' . $post_id . '&action=edit') . '"><strong>#' . $post_id . '</strong></a>';
      echo __(' by ', 'resido-listing') . '<strong>' . get_post_meta($post_id, 'rlisting_first_name', true) . ' ' . get_post_meta($post_id, 'rlisting_last_name', true) . '</strong>';
      echo '<br><small class="meta email"><a href="mailto:' . get_post_meta($post_id, 'rlisting_email', true) . '">' . get_post_meta($post_id, 'rlisting_email', true) . '</a></small>';
      echo '</div>';
      break;
    case 'status':
      echo get_post_meta($post_id, 'rlisting_status', true);
      break;
    case 'plan':
      echo get_post_meta($post_id, 'rlisting_package', true);
      break;
    case 'expire':
      $rlisting_expire = get_post_meta($post_id, 'rlisting_expire', true);
      if ($rlisting_expire) {
        $currentTime = time();
        $expire = strtotime($rlisting_expire);
        if ($currentTime <= $expire) {
          echo $rlisting_expire;
        } else {
          echo get_post_status($post_id);
          echo __('Subscription Expired', 'resido-listing');
        }
      } else {
        echo __('Never', 'resido-listing');
      }
      break;
      break;
    case 'package_id':
      echo get_post_meta($post_id, 'rlisting_package_id', true);
      break;
  }
}

// Add the custom columns to the book post type:
add_filter('manage_pricing_plan_posts_columns', 'pricing_plan_custom_edit_columns');
function pricing_plan_custom_edit_columns($columns)
{
  $columns['id'] = __('ID', 'resido-listing');
  $columns['price'] = __('Price', 'resido-listing');
  return $columns;
}

add_action('manage_pricing_plan_posts_custom_column', 'pricing_plan_custom_book_column', 10, 2);
function pricing_plan_custom_book_column($column, $post_id)
{
  switch ($column) {
    case 'id':
      echo $post_id;
      break;
    case 'price':
      echo get_post_meta($post_id, '_price', true);
      break;
  }
}
