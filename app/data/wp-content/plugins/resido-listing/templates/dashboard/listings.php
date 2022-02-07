<div class="dashboard-wraper">
  <!-- Bookmark Property -->
  <div class="form-submit">
    <h4><?php echo esc_html__('My Listings', 'resido-listing') ?></h4>
  </div>

  <div class="row">
    <?php
    global $current_user;
    $args = array(
      'author' => $current_user->ID,
      'post_type' => 'rlisting',
      'post_status' => array('publish', 'pending', 'draft'),
      'orderby' => 'post_date',
      'order' => 'DESC',
      'posts_per_page' => -1, // no limit,
    );
    $current_user_posts = get_posts($args);
    if (!empty($current_user_posts)) {

      foreach ($current_user_posts as $single_post) {
        $address = get_post_meta($single_post->ID, 'rlisting_address', true);
        $comments = get_comments(array('post_id' => $single_post->ID));
        $price = get_post_meta($single_post->ID, 'rlisting_sale_or_rent', true);
        $postfix = get_post_meta($single_post->ID, 'rlisting_price_postfix', true);
        $term_list = wp_get_post_terms($single_post->ID, 'rlisting_category', array('fields' => 'names'));
    ?>
        <!-- Single Property -->
        <div class="col-md-12 col-sm-12 col-md-12">
          <div class="singles-dashboard-list">
            <?php if ($single_post->post_status != 'publish') { ?>
              <span class="post-status"><?php esc_html_e('Pending', 'resido-listing'); ?></span>
            <?php }
            if (has_post_thumbnail($single_post->ID)) {
            ?>
              <div class="sd-list-left">
                <?php echo get_the_post_thumbnail($single_post->ID, array(240, 180)); ?>
              </div>
            <?php
            } else { ?>
              <div class="sd-list-left">
                <img src="<?php echo plugins_url('resido-listing') . '/assets/img/placeholder.png'; ?>" alt="">
              </div>
            <?php } ?>

            <div class="sd-list-right">
              <h4 class="listing_dashboard_title"><a href="<?php echo get_permalink($single_post->ID); ?>" class="theme-cl"><?php echo $single_post->post_title; ?></a></h4>
              <div class="user_dashboard_listed">
                <?php
                $listing_option = resido_listing_option();
                esc_html_e('Price: from ' . $listing_option['currency_symbol'] . $price . " " . $postfix, 'resido-listing'); ?>
              </div>
              <?php if ($term_list) { ?>
                <div class="user_dashboard_listed">
                  <?php echo esc_html('Listed in'); ?>
                  <?php foreach ($term_list as $term) {
                  ?><a href="<?php echo get_term_link($term, 'rlisting_category'); ?>" class="theme-cl"><?php echo $term; ?></a>
                  <?php } ?>
                </div>
              <?php }  ?>
              <div class="user_dashboard_listed">
                <?php echo $address; ?>
              </div>
              <div class="action">
                <a href="<?php echo site_url("dashboard/?dashboard=listings&editlisting=" . $single_post->ID); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="ti-pencil"></i></a>
                <a href="<?php echo get_permalink($single_post->ID); ?>" data-toggle="tooltip" data-placement="top" title="202 User View"><i class="ti-eye"></i></a>

                <?php
                if (current_user_can('administrator')) { ?>
                  <a onclick="return confirm('Do you really want to delete this Listing?')" href="<?php echo get_delete_post_link($single_post->ID); ?>" data-toggle="tooltip" data-placement="top" title="Delete Property" class="delete"><i class="ti-close"></i></a>
                <?php
                } else { ?>
                  <a id="delete-listing" data-listing-id="<?php echo $single_post->ID; ?>" onclick="return confirm('Do you really want to delete this Listing?')" class="delete-listing button gray" href="javascript:void(0);"><i class="ti-close"></i></a>
                <?php }

                $featured_state = get_post_meta($single_post->ID, 'featured', true);
                if (isset($featured_state) && $featured_state == 1) {
                  $icon_class = "ti-star";
                } else {
                  $icon_class = "fa fa-star";
                }
                ?>
                <a id="make-featured" data-listing-id="<?php echo $single_post->ID; ?>" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make Featured"><i class="<?php echo esc_attr($icon_class); ?>"></i></a>
              </div>
            </div>
          </div>
        </div>
    <?php }
    } else {
      echo '<p class="messages-headline">';
      echo esc_html__('No Listing Found', 'resido-listing');
      echo '</p>';
    }
    ?>
  </div>

</div>