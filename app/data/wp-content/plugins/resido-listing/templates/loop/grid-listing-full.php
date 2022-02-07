<?php
$term_name     = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
// $currentStatus = resido_get_current_working_status();
$listing_option = resido_listing_option();
$listing_avatar_image = isset($listing_option['listing_avatar_image']) ? $listing_option['listing_avatar_image'] : 1;
$currency_symbol = isset($listing_option['currency_symbol']) ? $listing_option['currency_symbol'] : '$';
$listing_item_price = isset($listing_option['listing_item_price']) ? $listing_option['listing_item_price'] : 'yes';
global $current_user;
// resido_get_favarited_meta_value($current_user->ID, get_the_ID());
?>
<!-- Single List -->
<div class="col-lg-4 col-md-6 col-sm-12">
  <div class="property_item classical-list">
    <div class="image">
      <a href="<?php the_permalink(); ?>" class="listing-thumb">
        <?php
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'rlisting_home_size_1');
        $image_id = get_post_thumbnail_id();
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        ?>
        <img src="<?php echo esc_url($featured_img_url); ?>" class="img-responsive" alt="<?php echo $image_alt; ?>" />
      </a>
      <div class="listing-price-info">
        <?php
        $is_featured = get_post_meta(get_the_ID(), 'featured');
        if ($is_featured) {
          echo '<span class="pricetag">' . __('Featured', 'resido-listing') . '</span>';
        }

        // resido_listing_price_tag($listing_item_price, $currency_symbol);

        ?>
      </div>
      <?php
      if (!is_user_logged_in()) {
        echo '<a href="#" data-toggle="modal" data-target="#login" class="tag_t"><i class="ti-heart"></i></a>';
      } else {
        $user_meta = get_user_meta($current_user->ID, '_favorite_posts');
        if (in_array(get_the_ID(), $user_meta)) {
          echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="tag_t active"  id="tag_t"' . get_the_ID() . '"><i class="ti-heart"></i>' . __('Save', 'resido-listing') . '</a>';
        } else {
          echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="tag_t" id="tag_t' . get_the_ID() . '"><i class="ti-heart"></i>' . __('Save', 'resido-listing') . '</a>';
        }
      }
      ?>

      <?php

      $comments = get_comments(
        array(
          'post_id' => get_the_ID(),
          'status'  => 'approve',
        )
      );
      if (!empty($comments)) {
        $comments       = count($comments);
        $average        = resido_get_average_rate(get_the_ID());
        $averageRounded = ceil($average);
        if (!is_nan($averageRounded)) {
          echo '<span class="list-rate great">' . $average . '</span>';
        }
      }
      ?>
    </div>


    <?php

    $author_class = 'without-author-avatar';

    if ($listing_avatar_image) {
      $author_class = 'author-avater';
    }

    ?>

    <div class="proerty_content">
      <div class="<?php echo $author_class; ?>">
        <?php
        if ($listing_avatar_image) {
          echo resido_get_avat();
        }
        ?>
      </div>
      <div class="proerty_text">
        <h3 class="captlize"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          <?php
          $varified = get_post_meta(get_the_ID(), 'varified', true);
          if ($varified) {
            echo ' <span class="veryfied-author"></span>';
          }
          ?>
        </h3>
      </div>
      <?php the_excerpt(); ?>
      <div class="property_meta">
        <div class="list-fx-features">
          <div class="listing-card-info-icon">
            <span class="inc-fleat inc-add">
              <?php
              echo resido_get_city_and_country_tax();
              ?>
            </span>
          </div>
          <div class="listing-card-info-icon">
            <a href="tel:<?php listing_meta_field('mobile'); ?>">
              <span class="inc-fleat inc-call">
                <?php listing_meta_field('mobile'); ?>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="listing-footer-info">

      <?php
      $listing_terms = wp_get_object_terms(get_the_ID(), 'rlisting_category');

      if ($listing_terms) { ?>
        <div class="listing-cat">
          <a href="
		<?php
        echo get_term_link($listing_terms[0]->term_id, 'rlisting_category');
    ?>
		" class="cat-icon cl-1">
            <?php
            $cat_icon = get_option("rlisting_category_{$listing_terms[0]->term_id}_icon");
            if (empty($cat_icon)) {
              $cat_icon = 'ti-briefcase bg-a';
            }
            ?>
            <i class="<?php echo $cat_icon; ?>"></i><?php echo $term_name[0]; ?></a>

        </div>

      <?php

      }

      ?>

      <?php
      if (!empty($currentStatus) && $currentStatus != 'Closed') {
        echo '<span class="place-status">' . __('Open', 'resido-listing') . '</span>';
      } else {
        echo '<span class="place-status closed">' . __('Closed', 'resido-listing') . '</span>';
      }
      ?>
    </div>
  </div>
</div>