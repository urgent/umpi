<?php

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
?>

<?php
if ($listing_style == '1') { ?>
  <input type="hidden" id="layout" name="layout" value="grid">
  <div class="order-2 col-lg-4 col-md-4 order-lg-1 order-md-1">
    <!-- property Sidebar -->
    <div class="exlip-page-sidebar">
      <!-- Find New Property -->
      <div class="sidebar-widgets">
        <?php if (is_active_sidebar('listingsidebar')) { ?>
          <?php dynamic_sidebar('listingsidebar'); ?>
        <?php } ?>
      </div>
    </div>
  </div>
  <!-- Sidebar End -->
  <div class="order-1 content-area col-lg-8 col-md-8 order-md-2 order-lg-2">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <?php include RESIDO_LISTING_PATH . '/templates/loop/shorting.php';
        ?>
      </div>
    </div>

    <div class="row" id="archive_loop">
      <!-- Single List Start -->
      <?php
      if ($custom_query->have_posts()) {
        while ($custom_query->have_posts()) {
          $custom_query->the_post();
          include RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php';
        }
      }
      wp_localize_script('resido_loadmore', 'resido_loadmore_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
        'layout' => 'grid',
        'posts' => json_encode($custom_query->query_vars), // everything about your loop is here
        'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
        'max_page' => $custom_query->max_num_pages,
      ));
      wp_enqueue_script('resido_loadmore');
      /* Restore original Post Data */
      wp_reset_postdata();
      ?>
    </div>

    <?php
    include RESIDO_LISTING_PATH . '/templates/loop/pagination.php';
    ?>
  </div>

<?php } elseif ($listing_style == '2') { ?>
  <div class="col-lg-12 col-md-12 col-sm-12">
    <?php include RESIDO_LISTING_PATH . '/templates/loop/shorting.php';
    ?>
  </div>
  </div>
  <input type="hidden" id="layout" name="layout" value="grid-full">
  <!-- Single List Start -->
  <div class="row" id="archive_loop">
    <?php
    if ($custom_query->have_posts()) {
      while ($custom_query->have_posts()) {
        $custom_query->the_post();
        include RESIDO_LISTING_PATH . '/templates/loop/grid-listing-full.php';
      }
    }
    wp_localize_script('resido_loadmore', 'resido_loadmore_params', array(
      'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
      'layout' => 'grid-full',
      'posts' => json_encode($custom_query->query_vars), // everything about your loop is here
      'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
      'max_page' => $custom_query->max_num_pages,
    ));
    wp_enqueue_script('resido_loadmore');
    /* Restore original Post Data */
    wp_reset_postdata();
    ?>
  </div>
  <?php
  include RESIDO_LISTING_PATH . '/templates/loop/pagination.php';
  ?>
<?php

} else { ?>
  <div class="col-lg-12 col-md-12 col-sm-12">
    <?php include RESIDO_LISTING_PATH . '/templates/loop/shorting.php';
    ?>
  </div>
  </div>
  <input type="hidden" id="layout" name="layout" value="grid-full">
  <!-- Single List Start -->
  <div class="row" id="archive_loop">
    <?php
    if ($custom_query->have_posts()) {
      while ($custom_query->have_posts()) {
        $custom_query->the_post();
        include RESIDO_LISTING_PATH . '/templates/loop/grid-listing-full.php';
      }
    }
    wp_localize_script('resido_loadmore', 'resido_loadmore_params', array(
      'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
      'layout' => 'grid-full',
      'posts' => json_encode($custom_query->query_vars), // everything about your loop is here
      'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
      'max_page' => $custom_query->max_num_pages,
    ));
    wp_enqueue_script('resido_loadmore');
    /* Restore original Post Data */
    wp_reset_postdata();
    ?>
  </div>
<?php
  include RESIDO_LISTING_PATH . '/templates/loop/pagination.php';
}
