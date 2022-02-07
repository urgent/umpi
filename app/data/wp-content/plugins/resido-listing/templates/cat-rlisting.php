<?php
get_header('listing');
$listing_option = get_option('resido_listings_options');
$ar_top_breadcrumb = resido_get_options('ar_top_breadcrumb');
$layout_sidebar = isset($listing_option['listing_layout_sidebar']) ? $listing_option['listing_layout_sidebar'] : '0';
// query vars
$listing_layout = get_query_var('editlisting');

if (isset($_COOKIE['shorting_layout']) && $_COOKIE['shorting_layout'] == 'grid') {
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
<input type="hidden" id="rl_taxonomy" name="rl_taxonomy" value="<?php echo esc_html(get_query_var('taxonomy')); ?>">
<input type="hidden" id="rl_term" name="rl_term" value="<?php echo esc_html(get_query_var('term')); ?>">
<?php if ($ar_top_breadcrumb == 1) {
  include RESIDO_LISTING_PATH . '/templates/archive/breadcrumb_title.php';
}

$args = array(
  'post_type' => 'rlisting',
  'paged' => $paged,
  'tax_query' => array(
    array(
      'taxonomy' => get_query_var('taxonomy'),
      'field'    => 'slug',
      'terms'    => get_query_var('term'),
    ),
  ),
);
$wp_query     = new WP_Query($args);
$post_on_page = count($wp_query->posts);
?>
<!-- ============================ All Property ================================== -->
<section class="gray">
  <div class="container">
    <div class="row">
      <?php if ($layout_sidebar) { ?>
        <!-- property Sidebar -->
        <div class="col-lg-4 col-md-4 col-sm-12">
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
          if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) {
              $wp_query->the_post();
              if ($layout_view == 'list') {
                include RESIDO_LISTING_PATH . '/templates/loop/listing.php';
              } else {
                include RESIDO_LISTING_PATH . '/templates/loop/grid-listing.php';
              }
            }
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
