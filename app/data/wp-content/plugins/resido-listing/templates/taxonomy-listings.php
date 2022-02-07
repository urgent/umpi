<?php
get_header('listing');
$resido_options = resido_options();
$resido_background_image = isset($resido_options['resido_background_image']) ? $resido_options['resido_background_image'] : 0;
$listing_option = get_option('resido_listings_options');
$layout_view = 'grid';
if (isset($listing_option['listing_layout_view']) && $listing_option['listing_layout_view']) {
  $layout_view = $listing_option['listing_layout_view'];
}

$view_extra_class = '';
if ($layout_view == 'list') {
  $view_extra_class = 'col-lg-12 col-md-12 col-sm-12';
}

?>
<div class="image-cover page-title" style="background:url(<?php echo esc_url($resido_background_image['url']); ?>) no-repeat;" data-overlay="6">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <h2 class="ipt-title"><?php echo esc_html__('Listings', 'resido-listing'); ?> </h2>
        <span class="ipn-subtitle text-light">
          <?php echo esc_html__('Who we are and our mission', 'resido-listing'); ?></span>
      </div>
    </div>
  </div>
</div>
<!-- =================== Sidebar Search ==================== -->
<section class="gray">
  <div class="container">
    <div class="row">
      <?php
      $category = get_queried_object();
      $category_slug = $category->slug;
      $wp_query = new WP_Query([
        'post_type' => 'rlisting',
        'post_status' => 'publish',
        'tax_query' => array(
          array(
            'taxonomy' => $category->taxonomy,
            'field' => 'slug',
            'terms' => $category_slug,
          ),
        ),
      ]);
      ?>
      <input type="hidden" id="layout" name="layout" value="<?php echo $layout_view ?>">
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
        <div class="row <?php echo $view_extra_class; ?>" id="archive_loop">
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
        <?php
        include RESIDO_LISTING_PATH . '/templates/loop/pagination.php';
        ?>
      </div>
    </div>
</section>
<!-- =================== Sidebar Search ==================== -->
<?php

if (isset($listing_option['footer_newsletter']) && $listing_option['footer_newsletter']) {
  $blog_footer_widget = isset($resido_options['resido_blog_footer_widget']) ? $resido_options['resido_blog_footer_widget'] : '';
  if (class_exists("\\Elementor\\Plugin")) {
    if (!empty($blog_footer_widget)) :
      $pluginElementor = \Elementor\Plugin::instance();
      $resido_blog_widget_element = $pluginElementor->frontend->get_builder_content($blog_footer_widget);
      echo do_shortcode($resido_blog_widget_element);
    endif;
  }
}
?>
<?php
get_footer();
