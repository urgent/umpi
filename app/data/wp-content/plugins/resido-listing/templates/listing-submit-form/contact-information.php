<div class="form-submit">
  <h3><?php echo esc_html__('Contact Information', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Name', 'resido-listing'); ?></label>
        <input type="text" name="rlname" class="form-control" value="">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Email', 'resido-listing'); ?></label>
        <input type="email" name="rlemail" class="form-control" value="">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Phone (optional)', 'resido-listing'); ?></label>
        <input type="text" name="rlphone" class="form-control" value="">
      </div>
      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Agency', 'resido-listing'); ?></label>
        <select id="rlagencyinfo" name='rlagencyinfo' class="form-control">
          <option value='<?php echo esc_html('0'); ?>'><?php echo esc_html_e('Select', 'resido-listing'); ?></option>
          <?php
          $current_user_id = get_current_user_id();
          $args = array(
            'post_type' => 'ragencies',
            'post_status' => 'publish',
            'author' => $current_user_id,
          );
          $current_agent_posts = get_posts($args);
          if (!empty($current_agent_posts)) {
            foreach ($current_agent_posts as $single_post) {
              if ($current_post->rlisting_rlagencyinfo == $single_post->ID) { ?>
                <option selected value='<?php echo $single_post->ID; ?>'><?php echo $single_post->post_title; ?></option>
              <?php } else { ?>
                <option value='<?php echo $single_post->ID; ?>'><?php echo $single_post->post_title; ?></option>
              <?php }
              ?>
          <?php }
          }
          wp_reset_query();
          ?>

        </select>
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Agent', 'resido-listing'); ?></label>
        <select id="agents" name='rlagentinfo' class="form-control">
          <?php
          if ($current_post->rlisting_rlagentinfo != '') {
            $xargs = array(
              'p' => $current_post->rlisting_rlagentinfo,
              'post_type' => 'ragents',
              'post_status' => 'publish',
              'author' => $current_user_id,
            );
            $xcurrent_agent_posts = get_posts($xargs);
          ?>
            <option value='<?php echo $current_post->rlisting_rlagentinfo; ?>'><?php echo $xcurrent_agent_posts[0]->post_title; ?></option>
          <?php } else { ?>
            <option value=''><?php echo esc_html__('No Agent Selected', 'resido-listing'); ?></option>
          <?php } ?>
        </select>
      </div>

    </div>
  </div>
</div>