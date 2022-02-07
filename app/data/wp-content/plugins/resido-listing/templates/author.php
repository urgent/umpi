<?php
get_header('listing');
$resido_options = resido_options();
$listing_option = get_option('resido_listings_options');
$resido_background_image = isset($resido_options['resido_background_image']) ? $resido_options['resido_background_image'] : 0;

?>
<div class="image-cover page-title" style="background:url(<?php echo esc_url($resido_background_image['url']); ?>) no-repeat;" data-overlay="6">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <h2 class="ipt-title"><?php echo esc_html__('Profile', 'resido-listing'); ?></h2>
        <span class="ipn-subtitle text-light">
          <?php echo esc_html__('Who we are &amp; our mission', 'resido-listing'); ?>
        </span>
      </div>
    </div>
  </div>
</div>
<!-- ============================ Our Story Start ================================== -->
<section class="pt-0 gray">
  <div class="container detail-wrap-up">
    <!-- row Start -->
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="autor-bio-wrap">
          <!-- author thumb -->
          <div class="author-thumb">
            <div class="author-thumb-pic">
              <?php
              global $wp_query;
              $current_author = $wp_query->get_queried_object();

              $author_id = $current_author->ID;

              $image_url = '';

              $wp_user_avatar = get_user_meta($author_id, "wp_user_avatar", true);
              if ($wp_user_avatar) {
                $image_url = wp_get_attachment_image_url($wp_user_avatar, 'thumbnail');
              } else {
                $image_url = get_avatar_url($author_id);
              }

              ?>
              <img src="<?php echo $image_url; ?>" class="img-fluid circle" alt="">
            </div>
            <div class="author-thumb-caption">
              <h4> <?php
                    the_author();
                    ?></h4>
              <span><?php echo resido_get_agent_meta($author_id, 'rweb_designer'); ?></span>
            </div>
          </div>
          <!-- author detail -->
          <div class="author-full-detail">
            <div class="author-bio-single-list">
              <i class="lni-map-marker"></i><?php _e('Location', 'resido-listing'); ?>
              <h6><?php echo resido_get_agent_meta($author_id, 'raddress'); ?></h6>
            </div>

            <div class="author-bio-single-list">
              <i class="ti-email"></i><?php _e('Email', 'resido-listing'); ?>
              <h6><?php
                  $user_email = get_the_author_meta('user_email');
                  if ($user_email) {
                    echo $user_email;
                  } else {
                    echo resido_get_agent_meta($author_id, 'user_email');
                  }
                  ?>
              </h6>
            </div>

            <div class="author-bio-single-list">
              <i class="lni-phone-handset"></i><?php _e('Call', 'resido-listing'); ?>
              <h6><?php echo resido_get_agent_meta($author_id, 'rphone'); ?></h6>
            </div>
          </div>
          <!-- Author List Count -->

          <?php
          $u_facebook = resido_get_usermeta('u_facebook');
          $u_twitter = resido_get_usermeta('u_twitter');
          $u_instagram = resido_get_usermeta('u_instagram');
          $u_linkedin = resido_get_usermeta('u_linkedin');
          ?>
          <div class="author-list-detail">
            <ul class="footer-bottom-social">
              <li><a href="<?php echo $u_facebook; ?>" target="_blank"><i class="ti-facebook"></i></a></li>
              <li><a href="<?php echo $u_twitter; ?>" target="_blank"><i class="ti-twitter"></i></a></li>
              <li><a href="<?php echo $u_instagram; ?>" target="_blank"><i class="ti-instagram"></i></a></li>
              <li><a href="<?php echo $u_linkedin; ?>" target="_blank"><i class="ti-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-8 col-md-8 col-sm-12">
        <!-- All Tab Content -->
        <div class="tab-content" id="author-tabContent">
          <!-- About Tab Content -->
          <div class="tab-pane fade show active" id="author-about" role="tabpanel" aria-labelledby="author-about-tab">
            <!-- About Content -->
            <div class="block-wrap">
              <div class="block-header">
                <h4 class="block-title"><?php _e('Bio', 'resido-listing'); ?></h4>
              </div>
              <div class="block-body">
                <p><?php echo resido_get_agent_meta($author_id, 'rabout'); ?></p>
              </div>
            </div>
            <!-- Featured Listings -->
            <div class="block-wrap">
              <div class="block-header">
                <h4 class="block-title">Featured Listings</h4>
              </div>
              <div class="block-body">
                <div class="row">
                  <?php

                  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $wp_query = new WP_Query([
                    'author' => $author_id,
                    'post_type' => 'rlisting',
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'posts_per_page' => 6,
                  ]);

                  if ($wp_query->have_posts()) {
                    while ($wp_query->have_posts()) {
                      $wp_query->the_post();
                      resido_listings_grid_listing();
                    }
                  }

                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /row -->
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
