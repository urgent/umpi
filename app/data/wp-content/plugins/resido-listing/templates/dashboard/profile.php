<div class="dashboard-wraper">
  <div class="form-submit">
    <h4 class="col-md-12"><?php echo esc_html__('My Account', 'resido-listing'); ?></h4>
    <?php
    $user_info = wp_get_current_user();
    global $current_user;

    if (isset($_POST['update_user_info']) && $_POST['update_user_info']) {

      if (!wp_verify_nonce($_REQUEST['user-meta-update'], 'resido_update_form')) {
        echo esc_html__('You are a cheater', 'resido-listing');
      }

      $rpackage     = sanitize_text_field($_POST['rpackage']);
      $rlname       = sanitize_text_field($_POST['rlname']);
      $remail       = sanitize_text_field($_POST['remail']);
      $rphone       = sanitize_text_field($_POST['rphone']);
      $raddress     = sanitize_text_field($_POST['raddress']);
      $rcity        = sanitize_text_field($_POST['rcity']);
      $rstate       = sanitize_text_field($_POST['rstate']);
      $rzip         = sanitize_text_field($_POST['rzip']);
      $rabout       = sanitize_textarea_field($_POST['rabout']);
      $u_facebook   = sanitize_textarea_field($_POST['u_facebook']);
      $u_twitter    = sanitize_textarea_field($_POST['u_twitter']);
      $u_linkedin   = sanitize_textarea_field($_POST['u_linkedin']);
      $u_instagram  = sanitize_textarea_field($_POST['u_instagram']);
      $user_id = $current_user->ID;
      $metas = array(
        'rpackage' => $rpackage,
        'rphone' => $rphone,
        'phone' => $rphone,
        'raddress' => $raddress,
        'rcity' => $rcity,
        'rstate' => $rstate,
        'rzip' => $rzip,
        'u_facebook' => $u_facebook,
        'u_twitter' => $u_twitter,
        'u_linkedin' => $u_linkedin,
        'u_instagram' => $u_instagram,
        'rabout' => $rabout,
        'user_email' => $remail,
      );

      if (!empty($rlname)) {
        wp_update_user(array('ID' => $user_id, 'display_name' => $rlname));
      }

      if (!empty($remail)) {
        wp_update_user(array('ID' => $user_id, 'user_email' => $remail));
      }

      foreach ($metas as $key => $value) {
        update_user_meta($user_id, $key, $value);
      }

      if (isset($_POST['user_avt']) && !empty($_POST['user_avt'])) {
        update_user_meta($user_id, "wp_user_avatar", $_POST['user_avt']);
      }
    }

    ?>
    <form id="wp_signup_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
      <div class="submit-section col-md-12">
        <div class="row">
          <div class="form-group col-md-12">
            <label><?php echo esc_html__('Change Avatar', 'resido-listing'); ?></label>
            <div class="avatar-image-upload dropzone">
              <?php
              $avatar_url = resido_get_avatar_url();
              if ($avatar_url) {
                echo '<img id="files_featured" width="90px"  height="90px" src="' . $avatar_url . '" alt="img" />';
              } else {
                echo '<img id="files_featured" src="#" alt="img" />';
              }
              ?>
              <label for="file-input" id="frontend-avatar" class="avt_label">
                <i class="lni-upload"></i>
                <br>
                <?php echo esc_html__(' Drop files here to upload', 'resido-listing'); ?>
              </label>
              <input id="user_avt" name="user_avt" type="hidden" />
            </div>
          </div>
          <div class="form-group col-md-6">
            <label><?php echo esc_html__('Your Name', 'resido-listing'); ?></label>
            <input type="text" name="rlname" class="form-control" value="<?php echo esc_html($current_user->display_name); ?>">
          </div>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('Email', 'resido-listing'); ?></label>
            <input type="email" name="remail" class="form-control" readonly value="<?php echo esc_html($current_user->user_email); ?>">
          </div>

          <?php
          $rpackage_args = array(
            'post_type' => 'rsubscription',
            'author' => $current_user->ID,
            'posts_per_page' => -1,
          );
          $rpackage_query = new \WP_Query($rpackage_args);
          $user_subscription_meta = get_user_meta($current_user->ID, 'rpackage', true);
          $subscripbed_package_name = get_post_meta($user_subscription_meta, 'rlisting_package', true);
          ?>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('Selected Package', 'resido-listing'); ?></label>
            <select name='rpackage' class="form-control">
              <?php
              if ($rpackage_query->posts) {
                foreach ($rpackage_query->posts as $key => $post) {
                  $package_name = get_post_meta($post->ID, 'rlisting_package', true);
                  if ($subscripbed_package_name == $package_name) {
                    $select_ed = 'selected';
                  } else {
                    $select_ed = null;
                  }
                  echo '<option ' . $select_ed . ' value="' . $post->ID . '">' . $package_name . '</option>';
                }
              } else { ?>
                <option value=""><?php echo esc_html__('No package Selected', 'resido-listings'); ?></option>
              <?php }
              ?>

            </select>
          </div>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('Phone', 'resido-listing'); ?></label>
            <input type="text" name="rphone" class="form-control" value="<?php echo resido_get_usermeta('rphone'); ?>">
          </div>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('Address', 'resido-listing'); ?></label>
            <input type="text" name="raddress" class="form-control" value="<?php echo resido_get_usermeta('raddress'); ?>">
          </div>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('City', 'resido-listing'); ?></label>
            <input type="text" name="rcity" class="form-control" value="<?php echo resido_get_usermeta('rcity'); ?>">
          </div>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('State', 'resido-listing'); ?></label>
            <input type="text" name="rstate" class="form-control" value="<?php echo resido_get_usermeta('rstate'); ?>">
          </div>

          <div class="form-group col-md-6">
            <label><?php echo esc_html__('Zip', 'resido-listing'); ?></label>
            <input type="text" name="rzip" class="form-control" value="<?php echo resido_get_usermeta('rzip'); ?>">
          </div>

          <div class="form-group col-md-12">
            <label><?php echo esc_html__('About', 'resido-listing'); ?></label>
            <textarea name="rabout" class="form-control"><?php echo resido_get_usermeta('rabout'); ?></textarea>
          </div>

          <h4 class="col-md-12"><?php echo esc_html__('Social Accounts', 'resido-listing'); ?></h4>
          <div class="submit-section col-md-12">
            <div class="row">

              <div class="form-group col-md-6">
                <label><?php echo esc_html__('Facebook', 'resido-listing'); ?></label>
                <input type="text" class="form-control" name="u_facebook" value="<?php echo resido_get_usermeta('u_facebook'); ?>">
              </div>

              <div class="form-group col-md-6">
                <label><?php echo esc_html__('Twitter', 'resido-listing'); ?></label>
                <input type="text" class="form-control" name="u_twitter" value="<?php echo resido_get_usermeta('u_twitter'); ?>">
              </div>

              <div class="form-group col-md-6">
                <label><?php echo esc_html__('LinkedIn', 'resido-listing'); ?></label>
                <input type="text" class="form-control" name="u_linkedin" value="<?php echo resido_get_usermeta('u_linkedin'); ?>">
              </div>

              <div class="form-group col-md-6">
                <label><?php echo esc_html__('Instagram', 'resido-listing'); ?></label>
                <input type="text" class="form-control" name="u_instagram" value="<?php echo resido_get_usermeta('u_instagram'); ?>">
              </div>
              <div class="form-group col-lg-12 col-md-12">
                <?php wp_nonce_field('resido_update_form', 'user-meta-update'); ?>
                <input type="submit" class="btn btn-theme" id="submitbtn" name="update_user_info" value="Save Changes" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>