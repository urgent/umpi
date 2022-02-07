<?php
$term_name = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
$term_ID = wp_get_object_terms(get_the_ID(), 'rlisting_category');
$rlisting_status = wp_get_object_terms(get_the_ID(), 'rlisting_status', array('fields' => 'names'));
if (isset($listing_layout) && !empty($listing_layout)) { //query var
  if ($listing_layout == "list_sidebar") {
    $column = "col-lg-12 col-md-12";
    $_SESSION['list_column_val'] = $column;
    $_SESSION['grid_column_val'] = "col-lg-6 col-md-6";
  } elseif ($listing_layout == "list") {
    $column = "col-lg-6 col-md-6";
    $_SESSION['list_column_val'] = $column;
    $_SESSION['grid_column_val'] = "col-lg-4 col-md-6";
  }
} else if (isset($listing_option['listing_list_layout_column']) && $listing_option['listing_list_layout_column']) {
  $column = $listing_option['listing_list_layout_column'];
  $_SESSION['grid_col'] = $listing_option['listing_grid_layout_column'];
  $_SESSION['list_column_val'] = $column;
} else if (isset($_SESSION['list_column_val'])) {
  if ($_SESSION['list_column_val']) {
    $column = $_SESSION['list_column_val'];
  }
} else if (isset($_SESSION['list_col'])) {
  if ($_SESSION['list_col']) {
    $column = $_SESSION['list_col'];
  }
} else {
  $column = "col-lg-12 col-md-12";
}
?>

<div class="<?php echo esc_attr($column); ?>">
  <div class="property-listing property-1">
    <?php if (has_post_thumbnail(get_the_ID())) { ?>
      <div class="listing-img-wrapper">
        <a href="<?php the_permalink(); ?>">
          <?php
          $featured_img_url = get_the_post_thumbnail_url(get_the_ID()); ?>
          <img src="<?php echo esc_url($featured_img_url); ?>" class="img-fluid mx-auto" alt="img" />
        </a>
      </div>
    <?php } ?>

    <div class="listing-content">
      <div class="listing-detail-wrapper-box">
        <div class="listing-detail-wrapper">
          <div class="listing-short-detail">
            <h4 class="listing-name"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>

            <?php
            $average = resido_get_average_rate(get_the_ID());
            $averageRounded = ceil($average);
            if ($averageRounded > 1) {
              $review_text = ' Reviews';
            } else {
              $review_text = ' Review';
            }
            if ($averageRounded) { ?>
              <div class="listing-short-detail">
                <div class="fr-can-rating" data-rating="5">
                  <?php
                  $active_comment_rate = $averageRounded;
                  for ($x = 1; $x <= $active_comment_rate; $x++) {
                    echo '<i class="fa fa-star filled"></i>';
                  }
                  $inactive_comment_rate = 5 - $active_comment_rate;
                  if ($inactive_comment_rate > 0) {
                    for ($x = 1; $x <= $inactive_comment_rate; $x++) {
                      echo '<i class="fa fa-star"></i>';
                    }
                  }
                  if(get_comments_number() == 1){
                  echo '<span class="reviews_text">(' . get_comments_number() . ' Review'  . ')</span>';
                  }else{
                  echo '<span class="reviews_text">(' . get_comments_number() . ' Reviews'  . ')</span>';
                  }?>
                </div>
              </div>
              <?php }
            if (isset($rlisting_status) && !empty($rlisting_status)) {
              foreach ($rlisting_status as $key => $rlisting_state) { ?>
                <span class="prt-types sale"><?php echo $rlisting_state; ?></span>
            <?php }
            }
            ?>

          </div>
          <div class="list-price">
            <h6 class="listing-card-info-price">
              <?php resido_currency_html(); ?>
            </h6>
          </div>
        </div>
      </div>

      <div class="price-features-wrapper">
        <div class="list-fx-features">
          <div class="listing-card-info-icon">
            <div class="inc-fleat-icon">
              <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bed.svg'; ?>" width="13" alt="" />
            </div><?php listing_meta_field('bedrooms'); ?>
            <?php echo esc_html__('Beds', 'resido-listing') ?>
          </div>
          <div class="listing-card-info-icon">
            <div class="inc-fleat-icon">
              <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bathtub.svg'; ?>" width="13" alt="" />
            </div><?php listing_meta_field('bathrooms'); ?>
            <?php echo esc_html__('Bath', 'resido-listing') ?>
          </div>
          <div class="listing-card-info-icon">
            <div class="inc-fleat-icon">
              <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/move.svg'; ?>" width="13" alt="" />
            </div><?php listing_meta_field('area_size'); ?>
            <?php listing_meta_field('area_size_postfix'); ?>
          </div>
        </div>
      </div>
      <div class="listing-footer-wrapper">
        <?php if (get_post_meta(get_the_ID(), "rlisting_address", true)) { ?>
          <div class="listing-locate">
            <span class="listing-location"><i class="ti-location-pin"></i><?php listing_meta_field('address'); ?></span>
          </div>
        <?php } ?>
        <div class="listing-detail-btn">
          <a href="<?php the_permalink(); ?>" class="more-btn"><?php echo esc_html_e('View', 'resido-listing'); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>