<div class="featured-slick">
  <div class="featured-slick-slide">
    <?php
    $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    if ($featured_image_url) {
    ?>
      <div>
        <a href="<?php echo esc_url($featured_image_url); ?>" class="mfp-gallery">
          <img src="<?php echo esc_url($featured_image_url); ?>" class="img-fluid mx-auto" alt="gallery" />
        </a>
      </div>
      <?php
    }
    $galleryImage = listing_meta_field_gallery('gallery-image');
    if (!empty($galleryImage)) {
      foreach ($galleryImage as $image_id) {
        $image_url = wp_get_attachment_url($image_id);
      ?>
        <div>
          <a href="<?php echo esc_url($image_url); ?>" class="mfp-gallery">
            <img src="<?php echo esc_url($image_url); ?>" class="img-fluid mx-auto" alt="gallery" />
          </a>
        </div>
    <?php
      }
    }
    ?>

  </div>
</div>
<section class="spd-wrap">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="slide-property-detail">
          <div class="slide-property-first">
            <div class="listname-into">
              <h2>
                <?php
                global $post;
                the_title();
                $term_name = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
                ?>
                <span class="prt-type rent"><?php echo $term_name[0]; ?></span>
              </h2>
              <span><i class="lni-map-marker"></i> <?php listing_meta_field('address'); ?></span>
            </div>
          </div>

          <div class="slide-property-sec">
            <div class="pr-all-info">
              <div class="pr-single-info">
                <div class="share-opt-wrap">
                  <button type="button" class="btn-share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="Share this">
                    <i class="lni-share"></i>
                  </button>
                  <?php
                  resido_user_share_opt();
                  ?>
                </div>
              </div>
              <div class="pr-single-info">
                <?php
                global $current_user;
                if (!is_user_logged_in()) {
                  echo '<a href="#" data-toggle="modal" data-target="#login" class="like-bitt add-to-favorite"><i class="lni-heart-filled"></i></a>';
                } else {
                  $user_meta = get_user_meta($current_user->ID, '_favorite_posts');
                  if (in_array(get_the_ID(), $user_meta)) {
                    echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="like-bitt add-to-favorite" id="like_listing' . get_the_ID() . '"><i class="lni-heart-filled"></i></a>';
                  } else {
                    echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="add-to-favorite" id="like_listing' . get_the_ID() . '"><i class="lni-heart-filled"></i></a>';
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>