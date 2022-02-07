<?php
get_header('listing');
$listing_option     = get_option('resido_listings_options');
$ar_top_breadcrumb  = resido_get_options('ar_top_breadcrumb');

if (!isset($listing_option['map_layout'])) {
  $map_layout = 0;
} else {
  $map_layout = $listing_option['map_layout'];
}

if (!isset($listing_option['listing_layout_sidebar'])) {
  $layout_sidebar = 1;
} else {
  $layout_sidebar = $listing_option['listing_layout_sidebar'];
}

// query vars
$listing_layout = get_query_var('editlisting');
$map_var = get_query_var('map_var');
if (!empty($map_var) && $map_var == 1) {
  $map_layout = 1;
}

if (!empty($listing_layout)) { // query vars
  $layoput_arr = explode('_', $listing_layout);
  $layout = '';
  $style = "";
  if (isset($layoput_arr[0])) {
    $style = $layoput_arr[0];
  }
  if (isset($layoput_arr[1])) {
    $layout = $layoput_arr[1];
  }


  if ($layout == 'sidebar') {
    $layout_sidebar = 1;
  } else {
    $layout_sidebar = 0;
  }
  $layout_view = "";
  $grid_class = "";
  $list_class = "";
  if ($style == "list") {
    $layout_view = "list";
    $list_class = "active";
    $grid_class = null;
  } elseif ($style == "grid") {
    $layout_view = "grid";
    $grid_class = "active";
    $list_class = null;
  }
} else if (isset($_COOKIE['shorting_layout']) && $_COOKIE['shorting_layout'] == 'grid') {
  $layout_view = "grid";
  $grid_class = "active";
  $list_class = null;
} else if (isset($_COOKIE['shorting_layout']) && $_COOKIE['shorting_layout'] == 'list') {
  $layout_view = "list";
  $list_class = "active";
  $grid_class = null;
} else if (isset($listing_option['listing_layout_view']) && $listing_option['listing_layout_view']) {
  $layout_view = $listing_option['listing_layout_view'];
  if ($layout_view == 'grid') {
    $layout_view = "grid";
    $grid_class = "active";
    $list_class = null;
  } else {
    $layout_view = "list";
    $list_class = "active";
    $grid_class = null;
  }
} else {
  $layout_view = 'list';
  $list_class = "active";
  $grid_class = null;
}

// Page width Class according to sidebar
if ($layout_sidebar == 0) {
  $listing_class = "col-lg-12 col-md-12";
} else {
  $listing_class = "col-lg-8 col-md-12";
}

?>
<input type="hidden" id="layout" name="layout" value="<?php echo esc_html($layout_view); ?>">
<?php if ($ar_top_breadcrumb == 1) {
  include RESIDO_LISTING_PATH . '/templates/archive/breadcrumb_title.php';
}
$wp_query = new WP_Query([
  'post_type' => 'rlisting',
  'post_status' => 'publish',
  'paged' => $paged,
]);
$post_on_page = count($wp_query->posts);
if ($map_layout == 1) { ?>
  <!-- Location Section -->
  <div class="arc-map-div hm-map-container fw-map">
    <div id="map">
    </div>
  </div>
  <!-- Location Section -->
<?php } ?>

<!-- ============================ All Property ================================== -->
<section class="gray">
  <div class="container">
    <div class="row">
      <?php if ($layout_sidebar) { ?>
        <!-- property Sidebar -->
        <div class="col-lg-4 col-md-12 col-sm-12">
          <?php if (is_active_sidebar('listingsidebar')) {
            dynamic_sidebar('listingsidebar');
          } ?>
        </div>
      <?php } ?>
      <div class="<?php echo esc_attr($listing_class); ?> list-layout">
        <div class="row justify-content-center">
          <div class="col-lg-12 col-md-12">
            <?php include RESIDO_LISTING_PATH . '/templates/loop/shorting.php'; ?>
          </div>
        </div>

        <div class="row" id="archive_loop">
          <!-- Single List Start -->
          <?php

          // Location Value Set
          if ($map_layout == 1) {
            $locations = [];
            $key_num = 0;
          }
          // Location Value Set

          if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) {
              $wp_query->the_post();

              // Location Value Set
              if ($map_layout == 1) {
                $category = resido_get_listing_cat(get_the_ID());
                $title = get_the_title();
                $featured_image_url                 = get_the_post_thumbnail_url(get_the_ID());
                $rlisting_latitude                  = resido_get_listing_meta(get_the_ID(), 'rlisting_latitude');
                $rlisting_longitude                 = resido_get_listing_meta(get_the_ID(), 'rlisting_longitude');
                $locations[$key_num]['url']         = get_post_permalink(get_the_ID());
                $locations[$key_num]['image']       = get_the_post_thumbnail_url(get_the_ID());
                $locations[$key_num]['price']       = $listing_option['currency_symbol'] . ' ' . get_post_meta(get_the_ID(), 'rlisting_sale_or_rent', true);
                $locations[$key_num]['category']    = $category;
                $locations[$key_num]['title']       = $title;
                $locations[$key_num]['latitude']    = $rlisting_latitude;
                $locations[$key_num]['longitude']   = $rlisting_longitude;
              }
              // Location Value Set

              if ($layout_view == 'list') {
                include RESIDO_LISTING_PATH . '/templates/loop/listing.php';
              } else {
                include RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php';
              }
              if ($map_layout == 1) {
                $key_num++;
              }
            }
            // Location Js Load
            if ($map_layout == 1) {
              wp_localize_script('resido-map', 'locations_obj', $locations);
            }
            // Location Js Load
            wp_localize_script('resido-map', 'resido_loadmore_params', array(
              'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
              'layout' => $layout_view,
              'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
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

    </div>
  </div>
</section>

<?php
get_footer();
