<div class="dashboard-wraper">
  <!-- Bookmark Property -->
  <div class="form-submit">
    <h4><?php echo _e('Bookmarked Listings', 'resido-listing'); ?></h4>
  </div>
  <table class="property-table-wrap responsive-table bkmark">
    <tbody>
      <tr>
        <th><i class="fa fa-file-text"></i> Property</th>
        <th></th>
      </tr>
      <?php
      global $current_user;
      $args = array(
        'post_type' => 'rlisting',
        'post_status' => 'publish',
        'orderby' => 'post_date',
        'order' => 'ASC',
        'posts_per_page' => -1, // no limit,
      );
      $user_meta = get_user_meta($current_user->ID, '_favorite_posts');
      $current_user_posts = get_posts($args);
      if (!empty($current_user_posts)) {
        foreach ($current_user_posts as $single_post) {
          if (in_array($single_post->ID, $user_meta)) {
            $address = get_post_meta($single_post->ID, 'rlisting_address', true);
            $comments = get_comments(array('post_id' => $single_post->ID));
            $price = get_post_meta($single_post->ID, 'rlisting_sale_or_rent', true);
            $postfix = get_post_meta($single_post->ID, 'rlisting_price_postfix', true);
      ?>
            <!-- Item #1 -->
            <tr id="bookmarked_<?php echo $single_post->ID ?>">
              <td class="property-container">
                <?php echo get_the_post_thumbnail($single_post->ID, array(240, 180)); ?>
                <div class="title">
                  <h4><a href="<?php echo get_permalink($single_post->ID); ?>"><?php echo $single_post->post_title; ?></a></h4>
                  <span><?php esc_html_e($address, 'resido-listing') ?></span>
                  <span class="table-property-price">$<?php esc_html_e($price . " / " . $postfix, 'resido-listing'); ?></span>
                </div>
              </td>
              <td class="action">
                <a href="javascript:void(0)" data-userid="<?php echo $current_user->ID ?>" data-postid="<?php echo $single_post->ID ?>" id="book_marked" class="delete book_marked"><i class="ti-close"></i> Delete</a>
              </td>
            </tr>
      <?php }
        }
      }
      ?>
    </tbody>
  </table>
</div>