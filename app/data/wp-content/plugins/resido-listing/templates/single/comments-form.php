<?php
$user = wp_get_current_user();
$commenter = wp_get_current_commenter();
$resido_user_identity = $user->display_name;
$req = get_option('require_name_email');
$listing_option = resido_listing_option();
$post_id = get_the_ID();
?>
<div class="review-form-box form-submit" id="respond">
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <!-- Single Write a Review -->
    <div class="property_block_wrap style-2">
      <div class="property_block_wrap_header">
        <a data-bs-toggle="collapse" data-parent="#comment" data-bs-target="#clTen" aria-controls="clTen" href="javascript:void(0);" aria-expanded="true">
          <h4 class="property_block_title"><?php echo esc_html__('Write a Review', 'resido-listing') ?></h4>
        </a>
      </div>
      <div id="clTen" class="panel-collapse collapse show">
        <div class="block-body">
          <div class="row">
            <div class="col-md-8">
              <div class="row">
                <?php
                $ratting_service = isset($listing_option['ratting_service']) ? $listing_option['ratting_service'] : 1;
                $ratting_price = isset($listing_option['ratting_price']) ? $listing_option['ratting_price'] : 1;
                $ratting_quality = isset($listing_option['ratting_quality']) ? $listing_option['ratting_quality'] : 1;
                $ratting_location = isset($listing_option['ratting_location']) ? $listing_option['ratting_location'] : 1;
                if ($ratting_service) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label><?php echo esc_html__('Service?', 'resido-listing'); ?></label>
                    <div class="rate-stars">
                      <input type="radio" id="st1" name="rservice" value="5" checked>
                      <label for="st1"></label>
                      <input type="radio" id="st2" name="rservice" value="4">
                      <label for="st2"></label>
                      <input type="radio" id="st3" name="rservice" value="3">
                      <label for="st3"></label>
                      <input type="radio" id="st4" name="rservice" value="2">
                      <label for="st4"></label>
                      <input type="radio" id="st5" name="rservice" value="1">
                      <label for="st5"></label>
                    </div>
                  </div>

                <?php
                }
                if ($ratting_price) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label><?php echo esc_html__('Price?', 'resido-listing'); ?></label>
                    <div class="rate-stars">
                      <input type="radio" name="rmoney" id="vst1" value="5" checked>
                      <label for="vst1"></label>
                      <input type="radio" name="rmoney" id="vst2" value="4">
                      <label for="vst2"></label>
                      <input type="radio" name="rmoney" id="vst3" value="3">
                      <label for="vst3"></label>
                      <input type="radio" name="rmoney" id="vst4" value="2">
                      <label for="vst4"></label>
                      <input type="radio" name="rmoney" id="vst5" value="1" required>
                      <label for="vst5"></label>
                    </div>
                  </div>
                <?php
                }
                if ($ratting_quality) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label><?php echo esc_html__('Quality?', 'resido-listing'); ?></label>
                    <div class="rate-stars">
                      <input type="radio" name="rcleanliness" id="cst1" value="5" checked>
                      <label for="cst1"></label>
                      <input type="radio" name="rcleanliness" id="cst2" value="4">
                      <label for="cst2"></label>
                      <input type="radio" name="rcleanliness" id="cst3" value="3">
                      <label for="cst3"></label>
                      <input type="radio" name="rcleanliness" id="cst4" value="2">
                      <label for="cst4"></label>
                      <input type="radio" name="rcleanliness" id="cst5" value="1" required>
                      <label for="cst5"></label>
                    </div>
                  </div>
                <?php
                }
                if ($ratting_location) {
                ?>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label><?php echo esc_html__('Location?', 'resido-listing'); ?></label>
                    <div class="rate-stars">
                      <input type="radio" name="rlocation" id="lst1" value="5" checked>
                      <label for="lst1"></label>
                      <input type="radio" name="rlocation" id="lst2" value="4">
                      <label for="lst2"></label>
                      <input type="radio" name="rlocation" id="lst3" value="3">
                      <label for="lst3"></label>
                      <input type="radio" name="rlocation" id="lst4" value="2">
                      <label for="lst4"></label>
                      <input type="radio" name="rlocation" id="lst5" value="1" required>
                      <label for="lst5"></label>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <?php
              $ratting_average_ratting = isset($listing_option['ratting_average_ratting']) ? $listing_option['ratting_average_ratting'] : 1;
              if ($ratting_average_ratting) {
              ?>
                <div class="avg-total-pilx">
                  <h4 class="high user_commnet_avg_rate"><?php echo esc_html('5'); ?></h4>
                  <span><?php echo esc_html__('Average Ratting', 'resido-listing'); ?></span>
                </div>
              <?php

              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div id="clTen" class="panel-collapse collapse show">
        <div class="block-body">
          <form class="simple-form">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <textarea id="comment" required name="comment" class="form-control ht-80" placeholder="<?php _e('Messages', 'resido-listing'); ?>" aria-required="true"></textarea>
                </div>
              </div>
              <?php if (!is_user_logged_in()) { ?>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <input id="author" class="form-control" required name="author" type="text" placeholder="<?php _e('Your Name', 'resido-listing'); ?>" value="" aria-required="true">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="form-group">
                    <input id="email" name="email" required class="form-control" type="email" placeholder="<?php _e('Your Email', 'resido-listing'); ?>" value="" aria-required="true">
                  </div>
                </div>
              <?php } ?>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <input name="submit" type="submit" id="submit" class="btn btn-theme-light-2 rounded" value="<?php _e('Submit Review', 'resido-listing'); ?>">
                  <input type="hidden" name="comment_post_ID" value="<?php echo $post_id; ?>" id="comment_post_ID">
                  <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Comment Form -->
    </div>
    <!-- Single Write a Review -->
  </form>
</div> <!-- #respond -->