<div class="form-submit">
  <h3><?php echo esc_html__('Video', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">
      <div class="form-group col-md-12">
        <div id="rlvideoimg-placeholder"></div>
        <input id="frontend_rlvideoimg" name="frontend_rlvideoimg" class="frontend-btn" type="file">
        <label for="frontend_rlvideoimg" class="drop_img_lst dropzone dz-clickable" id="single-logo">
          <i class="lni-upload"></i>
          <span class="dz-default dz-message"><?php echo esc_html__('Drop files here to upload', 'resido-listing'); ?></span>
        </label>
      </div>
      <div class="form-group col-md-12">
        <label><?php echo esc_html__('Video Link', 'resido-listing'); ?></label>
        <input class="form-control" value="" name="rlvideolink" type="text">
        <label><?php echo esc_html__('Video embed iFrame', 'resido-listing'); ?></label>
        <textarea name="rlvideoiframe" class="form-control" placeholder="<?php echo esc_html__('use this field for iframe if you want to show the video on the same page', 'resido-listing'); ?>"></textarea>
      </div>
    </div>
  </div>
</div>