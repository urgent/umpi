<?php
get_header();
$value        = get_query_var('dashboard');
$editlisting  = get_query_var('editlisting');
$editagency   = get_query_var('editagency');
$editagent    = get_query_var('editagent');

if (!is_user_logged_in()) {
  $container_class = 'container';
} else {
  $container_class = 'container-fluid';
}

?>
<!-- ============================ Dashboard Start ================================== -->
<section class="gray">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="filter_search_opt">
          <a id="dash_nav_eng" href="javascript:void(0);"><?php echo esc_html__('Dashboard Navigation', 'resido-listing') ?><i class="ml-2 ti-menu"></i></a>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      if (!is_user_logged_in()) { ?>
        <div class="col-lg-12 col-md-12">
          <div class="alert alert-success" role="alert">
            <p><?php echo esc_html_e('Please, Sign In before you submit a property. If you don\'t have an account you can create one by', 'resido-listing') ?> <a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#login" class="text-success"><?php echo esc_html_e('Clicking Here', 'resido-listing') ?></a></p>
          </div>
        </div>
      <?php } else {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $usr_img_url = get_avatar_url($user_id);
        $rcity = '';
        $rstate = '';
        $rcity = get_user_meta($user_id, 'rcity', true);
        $rstate = get_user_meta($user_id, 'rstate', true);
        $query_variable = get_query_var('dashboard');
      ?>
        <div class="col-lg-3 col-md-4 col-sm-12">
          <div class="simple-sidebar sm-sidebar" id="filter_search">
            <div class="search-sidebar_header">
              <h4 class="ssh_heading"><?php echo esc_html('Close Filter'); ?></h4>
              <button id="dash_nav_dis" class="w3-bar-item w3-button w3-large"><i class="ti-close"></i></button>
            </div>
            <div class="d-user-avater">
              <?php
              echo resido_get_avat_by_user();
              ?>
              <h4><?php echo $current_user->display_name; ?></h4>
              <span><?php echo $rcity . ' ' . $rstate; ?></span>
            </div>
            <div class="d-navigation">
              <ul>
                <li <?php if ($query_variable == '') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard'); ?>">
                    <i class="ti-dashboard"></i><?php echo esc_html__('Dashboard', 'resido-listing'); ?></a>
                </li>
                <li <?php if ($query_variable == 'profile') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=profile'); ?>"><i class="ti-user"></i>
                    <?php echo esc_html__('My Profile', 'resido-listing'); ?>
                  </a>
                </li>
                <li <?php if ($query_variable == 'message') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=message'); ?>">
                    <i class="ti-email"></i> <?php echo esc_html__('Messages', 'resido-listing'); ?></a>
                </li>

                <li <?php if ($query_variable == 'agency') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=agency'); ?>">
                    <i class="ti-home"></i> <?php echo esc_html__('Agency', 'resido-listing'); ?></a>
                </li>

                <li <?php if ($query_variable == 'agent') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=agent'); ?>">
                    <i class="ti-user"></i> <?php echo esc_html__('Agent', 'resido-listing'); ?></a>
                </li>

                <li>
                  <a href="<?php echo site_url('add-listing'); ?>"><i class="ti-plus"></i>

                    <?php echo esc_html__('Add Listing', 'resido-listing'); ?>
                  </a>
                </li>
                <li <?php if ($query_variable == 'listings') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=listings'); ?>"><i class="ti-layers-alt"></i>
                    <?php echo esc_html__('My Listings', 'resido-listing'); ?> </a>
                </li>
                <li <?php if ($query_variable == 'bookmarked') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=bookmarked'); ?>"><i class="ti-heart"></i>
                    <?php echo esc_html__('Bookmarked Listings', 'resido-listing'); ?>
                  </a>
                </li>
                <li <?php if ($query_variable == 'changepassword') {
                      echo 'class="active"';
                    }
                    ?>>
                  <a href="<?php echo site_url('dashboard/?dashboard=changepassword'); ?>"><i class="ti-unlock"></i>
                    <?php echo esc_html__('Change Password', 'resido-listing'); ?>
                  </a>
                </li>
                <li>
                  <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="ti-power-off"></i>
                    <?php echo esc_html__('Log Out', 'resido-listing'); ?>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12">
          <?php
          if ('message' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/message.php';
          } elseif ('profile' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/profile.php';
          } elseif ('listings' === $value && $editlisting) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/editlisting.php';
          } elseif ('agency' === $value && $editagency) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/editagency.php';
          } elseif ('agent' === $value && $editagent) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/editagent.php';
          } elseif ('listings' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/listings.php';
          } elseif ('bookmarked' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/bookmarked.php';
          } elseif ('changepassword' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/changepassword.php';
          } elseif ('agency' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/agency.php';
          } elseif ('agent' === $value) {
            include RESIDO_LISTING_PATH . '/templates/dashboard/agent.php';
          } else {
            include RESIDO_LISTING_PATH . '/templates/dashboard/dashboard.php';
          }
          ?>

        </div>
      <?php
      }
      ?>
    </div>
  </div>
</section>
<!-- ============================ Dashboard End ================================== -->
<?php

get_footer();
