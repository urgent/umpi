<?php
$ajax_var = array(
  'ajax_url' => esc_url(admin_url('admin-ajax.php')),
  'site_url' => esc_url(site_url()),
  'listing_type' => 'list',
);
//wp_localize_script('listing-custom', 'ajax_obj', $ajax_var);
$settings = $this->get_settings_for_display();
$order_by = $settings['order_by'];
$order = $settings['order'];
$pg_num = get_query_var('paged') ? get_query_var('paged') : 1;
$listing_option = resido_listing_option();
$args = array(
  'post_type' => 'rlisting',
  'post_status' => 'publish',
  'paged' => $pg_num,
  'posts_per_page' => isset($listing_option['listing_post_per_page']) ? $listing_option['listing_post_per_page'] : '12',
  'orderby' => $order_by,
  'order' => $order,
);

$custom_query = new WP_Query($args);

if ($_COOKIE['shorting_layout'] == 'grid') {
  $layout_view = "grid";
  $grid_class = "active";
  $list_class = null;
} else if ($_COOKIE['shorting_layout'] == 'list') {
  $layout_view = "list";
  $list_class = "active";
  $grid_class = null;
} else {
  $layout_view = 'list';
  $list_class = "active";
  $grid_class = null;
}

if ($listing_style == '1') { ?>
  <input type="hidden" id="layout" name="layout" value="list">
  <!-- ============================ All Property ================================== -->
  <!-- property Sidebar -->
  <div class="col-lg-4 col-md-12 col-sm-12">
    <?php if (is_active_sidebar('listingsidebar')) {
      dynamic_sidebar('listingsidebar');
    } ?>
  </div>

  <div class="col-lg-8 col-md-12 list-layout">
    <div class="row justify-content-center">
      <div class="col-lg-12 col-md-12">
        <?php include RESIDO_LISTING_PATH . '/templates/loop/shorting.php'; ?>
      </div>
    </div>
    <div class="row" id="archive_loop">
      <!-- Single List Start -->
      <?php
      if ($custom_query->have_posts()) {
        while ($custom_query->have_posts()) {
          $custom_query->the_post();
          if ($layout_view == 'grid') {
            include RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php';
          } else {
            include RESIDO_LISTING_PATH . '/templates/loop/listing.php';
          }
        }
        wp_localize_script('resido-map', 'resido_loadmore_params', array(
          'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
          'layout' => $layout_view,
          'posts' => json_encode($custom_query->query_vars), // everything about your loop is here
          'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
          'max_page' => $wp_query->max_num_pages,
        ));
        //wp_enqueue_script('resido_loadmore');
      } else {
        echo '<p class="no-result">' . __('Sorry, nothing matched your search criteria', 'resido-listing') . '</p>';
      }
      /* Restore original Post Data */
      wp_reset_postdata();
      ?>
    </div>
    <!-- Pagination -->
    <?php include RESIDO_LISTING_PATH . '/templates/loop/pagination.php'; ?>
  </div>


<?php } elseif ($listing_style == '2') { ?>
  <div class="col-lg-12 col-md-12 list-layout">
    <div class="row justify-content-center">
      <div class="col-lg-12 col-md-12">
        <?php include RESIDO_LISTING_PATH . '/templates/loop/shorting.php'; ?>
      </div>
    </div>
    <div class="row" id="archive_loop">
      <!-- Single List Start -->
      <?php
      if ($custom_query->have_posts()) {
        while ($custom_query->have_posts()) {
          $custom_query->the_post();
          if ($layout_view == 'grid') {
            include RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php';
          } else {
            include RESIDO_LISTING_PATH . '/templates/loop/listing.php';
          }
        }
        wp_localize_script('resido-map', 'resido_loadmore_params', array(
          'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
          'layout' => $layout_view,
          'posts' => json_encode($custom_query->query_vars), // everything about your loop is here
          'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
          'max_page' => $wp_query->max_num_pages,
        ));
        //wp_enqueue_script('resido_loadmore');
      } else {
        echo '<p class="no-result">' . __('Sorry, nothing matched your search criteria', 'resido-listing') . '</p>';
      }
      /* Restore original Post Data */
      wp_reset_postdata();
      ?>
    </div>
    <!-- Pagination -->
    <?php include RESIDO_LISTING_PATH . '/templates/loop/pagination.php'; ?>

  </div>
<?php } ?>