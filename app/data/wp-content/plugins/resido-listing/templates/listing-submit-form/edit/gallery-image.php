<div class="form-submit">
  <h3><?php _e('Gallery', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">
      <div class="form-group col-md-12">
        <!-- Logo -->
        <div class="row">
          <?php
          $galleryImage = listing_meta_edit_field_gallery($editpostid, 'gallery-image');
          if (!empty($galleryImage)) {
            foreach ($galleryImage as $image_id) {
              $image_url = wp_get_attachment_url($image_id); ?>

              <div class="col-md-2">
                <div class="prev_img_sec ti-image-gallery-item">
                  <a class="remove-uploaded-img" id="delete_icon<?php echo $image_id; ?>" data-postid="<?php echo $editpostid; ?>" data-gimage="<?php echo $image_id; ?>" href="javascript:void(0)"><i class="ti-close" aria-hidden="true"></i></a>
                  <img src="<?php echo esc_url($image_url); ?>" id="deletegimage<?php echo $image_id; ?>" class="gallary_iamge_with" alt="gallery" />
                </div>
              </div>

          <?php
            }
          }
          ?>
        </div>
        <div id="myplugin-placeholder"></div>
        <input id="myplugin-change-image" name="myplugin-change-image" class="frontend-btn" type="file">
        <label for="myplugin-change-image" class="drop_img_lst dropzone dz-clickable" id="single-logo">
          <i class="lni-upload"></i>
          <span class="dz-default dz-message"><?php echo esc_html__('Drop files here to upload', 'resido-listing'); ?></span>
        </label>
      </div>
    </div>
  </div>
</div>