<?php
global $wp_query; // you can remove this line if everything works for you
// don't display the button if there are not enough posts
if ($wp_query->max_num_pages > 1 || (isset($custom_query->max_num_pages) && $custom_query->max_num_pages > 1)) {
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  if (!isset($listing_option['pagination_layout'])) {
    $pagination_layout = '1';
  } else {
    $pagination_layout = $listing_option['pagination_layout'];
  }

  if ($pagination_layout == '1') { ?>
    <!-- Normal Pagination -->
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="pagination p-center">
          <?php
          the_posts_pagination(
            array(
              'mid_size'  => 2,
              'prev_text' => '<span class="ti-arrow-left"></span>',
              'next_text' => '<span class="ti-arrow-right"></span>',
            )
          );
          ?>
        </div>
      </div>
    </div>
    <!-- Normal Pagination -->
  <?php
  } else { ?>
    <div class="row">
      <div class="col-md-12 col-sm-12 mt-3">
        <div id="ajax_scroll_loadmore">
          <div id="loading_tag" class="text-center">
            <div class="resido_loadmore btn btn-theme" data-page_num="1">
              <?php echo esc_html__('Load More', 'resido-listing'); ?></div>
          </div>
        </div>
      </div>
    </div>
<?php }
}
