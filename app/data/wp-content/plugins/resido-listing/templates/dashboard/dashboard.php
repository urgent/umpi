<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <?php
    $user_subscription_meta = get_user_meta($current_user->ID, 'rpackage', true);
    if (isset($user_subscription_meta) && $user_subscription_meta != '') {
      if (get_post_status($user_subscription_meta) == 'publish') {
        $package_id = get_post_meta($user_subscription_meta, 'rlisting_package_id', true);
        $package_name = get_post_meta($user_subscription_meta, 'rlisting_package', true);
        $expiry_date = get_post_meta($user_subscription_meta, 'rlisting_expire', true);
        $limit_count = get_post_meta($package_id, 'rlisting_list_subn_limit', true);
    ?>
        <h4><?php echo esc_html__('Your Current Package: ', 'resido-listing'); ?>
          <span class="pc-title theme-cl"><?php echo esc_html($package_name); ?></span>
        </h4>
      <?php
      } else {
        update_user_meta($current_user->ID, 'rpackage', null);
      }
    } else {
      $args = array(
        'post_type' => 'rsubscription',
        'author' => $current_user->ID,
        'posts_per_page' => -1,
      );
      $query = new \WP_Query($args);
      $limit_count = 0;
      if ($query->have_posts()) : ?>
        <h4><?php echo esc_html__('Your Current Package', 'resido-listing'); ?>
          <span class="pc-title theme-cl">
            <?php
            while ($query->have_posts()) :
              $query->the_post();
              $package_id = get_post_meta($post->ID, 'rlisting_package_id', true);
              $package_name = get_post_meta($post->ID, 'rlisting_package', true);
              $expiry_date = get_post_meta($post->ID, 'rlisting_expire', true);
              $limit_count = $limit_count + get_post_meta($package_id, 'rlisting_list_subn_limit', true);
              echo esc_html('- ' . $package_name);
            endwhile; ?>
          </span>
        </h4>
      <?php else : ?>
        <h4><?php echo esc_html_e('Currently No Package Selected', 'resido-listing'); ?></h4>
    <?php
      endif;
      wp_reset_query();
    }
    ?>
  </div>
</div>

<!-- Row -->
<div class="row">
  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="dashboard-stat widget-1">
      <div class="dashboard-stat-content">
        <h4><?php echo resido_total_active_lingting_by_user(); ?></h4>
        <span><?php echo esc_html__('Listings Included', 'resido-listing'); ?></span>
      </div>
      <div class="dashboard-stat-icon"><i class="ti-location-pin"></i></div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="dashboard-stat widget-2">
      <div class="dashboard-stat-content">
        <h4><?php echo $limit_count - resido_total_active_lingting_by_user(); ?></h4> <span>
          <?php echo esc_html__('Listings Remaining', 'resido-listing'); ?></span>
      </div>
      <div class="dashboard-stat-icon"><i class="ti-pie-chart"></i></div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="dashboard-stat widget-3">
      <div class="dashboard-stat-content">
        <h4><?php echo resido_total_review(); ?></h4>
        <span><?php echo esc_html__('Total Review', 'resido-listing'); ?></span>
      </div>
      <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="dashboard-stat widget-4">
      <div class="dashboard-stat-content">
        <h4><?php echo resido_total_saved(); ?></h4>
        <span><?php echo esc_html__('Bookmarked', 'resido-listing'); ?></span>
      </div>
      <div class="dashboard-stat-icon"><i class="ti-bookmark"></i></div>
    </div>
  </div>

  <?php if (!empty($expiry_date)) { ?>
    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="dashboard-stat widget-5">
        <div class="dashboard-stat-content">
          <h4><?php echo esc_html('Unlimited') ?></h4> <span><?php echo esc_html__('Images / per listing', 'resido-listing') ?></span>
        </div>
        <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12">
      <div class="dashboard-stat widget-6">
        <div class="dashboard-stat-content">
          <h4><?php
              echo $expire_date = date('Y-m-d', strtotime($expiry_date)); ?></h4>
          <span><?php echo esc_html__('Ends On', 'resido-listing') ?></span>
        </div>
        <div class="dashboard-stat-icon"><i class="ti-pie-chart"></i></div>
      </div>
    </div>
  <?php } ?>



</div>