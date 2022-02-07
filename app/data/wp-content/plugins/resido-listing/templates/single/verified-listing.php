<?php
$varified = get_post_meta(get_the_ID(), 'varified', true);
if ($varified) {?>
<div class="verified-list mb-4">
  <i class="ti-check"></i>
  <?php echo esc_html__(' Verified Listing', 'resido-listing'); ?>
</div>
<?php
}