<?php
global $wp_query; // you can remove this line if everything works for you
// don't display the button if there are not enough posts
if ($wp_query->max_num_pages > 1 || (isset($custom_query->max_num_pages) && $custom_query->max_num_pages > 1)) {
?>
  <div class="col-md-12 col-sm-12 mt-3">
    <div id="ajax_scroll_loadmore">
      <div id="loading_tag" class="text-center">
        <div class="resido_loadmore_map" data-page_num="1">
          <?php echo esc_html__('Read More', 'resido-listing'); ?></div>
      </div>
    </div>
  </div>
<?php
}
