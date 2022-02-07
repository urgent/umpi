<div class="form-submit">
  <h3><?php _e('Featured Image', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">
      <div class="form-group col-md-12">
        <label><?php _e('Upload Gallery', 'resido-listing'); ?></label>
        <input id="frontend_rlfeaturedimg" name="frontend_rlfeaturedimg" type="hidden" value="" />
        <input id="frontend-button" name="frontend-button" class="frontend-btn" type="file">
        <label for="frontend-button" class="drop_img_lst dropzone dz-clickable" id="single-logo">
          <i class="ti-gallery"></i>
          <span class="dz-default dz-message">
            <?php echo esc_html__('Drop files here to upload', 'resido-listing'); ?>
          </span>
        </label>
      </div>
    </div>
  </div>
</div>