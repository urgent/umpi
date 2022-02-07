<div class="form-submit">
  <h3><?php echo esc_html__('Video Link', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">

      <div class="form-group col-md-12">
        <div id="rlvideoimg-placeholder"> </div>
        <?php
        $v_image = listing_meta_edit_field_gallery($editpostid, 'v_image');
        if (!empty($v_image)) {
          foreach ($v_image as $image_id) {
            $image_url = wp_get_attachment_url($image_id);
            if ($image_url) { ?>
              <div class="col-md-2">
                <div class="prev_img_sec ti-image-gallery-item">
                  <a class="remove-uploaded-img" id="delete_icon<?php echo $image_id; ?>" data-postid="<?php echo $editpostid; ?>" data-gimage="<?php echo $image_id; ?>" href="javascript:void(0)"><i class="ti-close" aria-hidden="true"></i></a>
                  <img src="<?php echo esc_url($image_url); ?>" id="deletegimage<?php echo $image_id; ?>" class="gallary_iamge_with" alt="gallery" />
                </div>
              </div>
        <?php }
          }
        }
        ?>
        <input id="frontend_rlvideoimg" name="frontend_rlvideoimg" class="frontend-btn" type="file">
        <label for="frontend_rlvideoimg" class="drop_img_lst dropzone dz-clickable" id="single-logo">
          <i class="lni-upload"></i>
          <span class="dz-default dz-message"><?php echo esc_html__('Drop files here to upload', 'resido-listing'); ?></span>
        </label>
      </div>
      <div class="form-group col-md-12">
        <label><?php echo esc_html__('Video Link', 'resido-listing'); ?></label>
        <input class="form-control" value="<?php echo resido_get_listing_meta($editpostid, 'rlisting_videolink'); ?>" name="rlvideolink" type="text">
        <label><?php echo esc_html__('Video iFrame', 'resido-listing'); ?></label>
        <textarea name="rlvideoiframe" class="form-control"><?php echo resido_get_listing_meta($editpostid, 'rlisting_videoiframe'); ?></textarea>
      </div>
    </div>
  </div>
</div>