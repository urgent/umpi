<?php
$term_name = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
$term_ID = wp_get_object_terms(get_the_ID(), 'rlisting_category');
$rlisting_status = wp_get_object_terms(get_the_ID(), 'rlisting_status', array('fields' => 'names'));

// From elementor widget to create border and no-shadow for slide
$inner_class = '';
$layout_val = '';

if (isset($listing_option['listing_layout_view']) && $listing_option['listing_layout_view']) {
  $layout_val = $listing_option['listing_layout_view'];
  $_SESSION['layout_val'] = $layout_val;
} else if (isset($_SESSION['layout_val'])) {
  $layout_val = $_SESSION['layout_val'];
} else {
  $layout_val = null;
}

if (isset($listing_layout) && !empty($listing_layout)) {
  if ($listing_layout == "grid_sidebar") {
    $column = "col-lg-6 col-md-6";
    $_SESSION['grid_column_val'] = $column;
    $_SESSION['list_column_val'] = "col-lg-12 col-md-12";
  } elseif ($listing_layout == "gridc_sidebar") {
    $column = "col-lg-6 col-md-6";
    $_SESSION['grid_column_val'] = $column;
    $_SESSION['list_column_val'] = "col-lg-12 col-md-12";
    $layout_val = 'classic';
    $_SESSION['layout_val'] = $layout_val;
  } elseif ($listing_layout == "gridc") {
    $column = "col-lg-4 col-md-6";
    $_SESSION['grid_column_val'] = $column;
    $_SESSION['list_column_val'] = "col-lg-6 col-md-6";
    $layout_val = 'classic';
    $_SESSION['layout_val'] = $layout_val;
  } elseif ($listing_layout == "grid") {
    $column = "col-lg-4 col-md-6";
    $_SESSION['grid_column_val'] = $column;
    $_SESSION['list_column_val'] = "col-lg-6 col-md-6";
  }
} else if (isset($listing_option['listing_grid_layout_column']) && $listing_option['listing_grid_layout_column']) {
  $column = $listing_option['listing_grid_layout_column'];
  $_SESSION['list_col'] = $listing_option['listing_list_layout_column'];
  $_SESSION['grid_column_val'] = $column;
} else if (isset($_SESSION['grid_column_val'])) {
  $column = $_SESSION['grid_column_val'];
} else if (isset($_SESSION['grid_col'])) {
  $column = $_SESSION['grid_col'];
} else {
  $column = "col-lg-6 col-md-6";
}
?>
<div class="<?php echo esc_attr($column); ?>">
  <div class="property-listing property-2 <?php echo $inner_class; ?>">
    <div class="listing-img-wrapper">
      <div class="list-img-slide">
        <div class="click">
          <?php if (has_post_thumbnail(get_the_ID())) { ?>
            <div><a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail(); ?></a>
            </div>
            <?php }
          $galleryImage = listing_meta_field_gallery('gallery-image');
          if (!empty($galleryImage)) {
            foreach ($galleryImage as $image_id) {
              $image_url = wp_get_attachment_url($image_id);
            ?>
              <div><a href="<?php the_permalink(); ?>">
                  <img src="<?php echo esc_url($image_url); ?>" class="img-fluid mx-auto" alt="" /></a>
              </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
    <div class="listing-detail-wrapper">
      <div class="listing-short-detail-wrap">
        <?php if ($layout_val == 'classic') { ?>
          <!-- Classical Layout -->
          <div class="listing-short-detail">
            <h4 class="listing-name verified"><a href="<?php the_permalink(); ?>" class="prt-link-detail"><?php the_title() ?></a></h4>
            <div class="property-reviews">
              <?php
              $average = resido_get_average_rate(get_the_ID());
              $averageRounded = ceil($average);
              if ($averageRounded) {
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
              }
              ?>
            </div>
          </div>
          <!-- Classical Layout -->
        <?php } else {
        ?>
          <!-- Grid Layout -->
          <div class="listing-short-detail">
            <?php
            if (isset($rlisting_status) && !empty($rlisting_status)) {
              foreach ($rlisting_status as $key => $rlisting_state) { ?>
                <span class="property-type"><?php echo $rlisting_state; ?></span>
            <?php }
            }
            ?>
            <h4 class="listing-name verified">
              <a href="<?php the_permalink(); ?>" class="prt-link-detail"><?php the_title() ?></a>
            </h4>
          </div>
          <!-- Grid Layout -->
        <?php } ?>
        <div class="listing-short-detail-flex">
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
          </div><?php listing_meta_field('bedrooms');
                echo esc_html__('Beds', 'resido-listing'); ?>
        </div>
        <div class="listing-card-info-icon">
          <div class="inc-fleat-icon">
            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bathtub.svg'; ?>" width="13" alt="" />
          </div><?php listing_meta_field('bathrooms');
                echo esc_html__('Bath', 'resido-listing'); ?>
        </div>
        <div class="listing-card-info-icon">
          <div class="inc-fleat-icon">
            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/move.svg'; ?>" width="13" alt="" />
          </div><?php listing_meta_field('area_size'); ?><?php listing_meta_field('area_size_postfix'); ?>
        </div>
      </div>
    </div>
    <div class="listing-detail-footer">
      <div class="footer-first">
        <?php if (get_post_meta(get_the_ID(), "rlisting_address", true)) { ?>
          <div class="foot-location">
            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/pin.svg'; ?>" width="18" alt="" /><?php listing_meta_field('address'); ?>
          </div>
        <?php } ?>
      </div>
      <div class="footer-flex">
        <a href="<?php the_permalink(); ?>" class="prt-view"><?php echo esc_html__('View', 'resido-listing'); ?></a>
      </div>
    </div>
  </div>
</div>
<!-- End Single Property -->