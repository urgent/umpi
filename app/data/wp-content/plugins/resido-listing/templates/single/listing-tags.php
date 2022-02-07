	<!-- Tags -->
	<?php
$listing_tags = get_the_terms(get_the_ID(), 'rlisting_tags');
if ($listing_tags) {
    ?>
	<div class="tr-single-box">
	  <div class="tr-single-header">
	    <h4><i class="lni-tag"></i> <?php echo esc_html__('Tags', 'resido-listing') ?></h4>
	  </div>
	  <div class="tr-single-body">
	    <ul class="extra-service half">
	      <?php
foreach ($listing_tags as $tag_obj) {
        ?>
	      <li>
	        <div class="icon-box-icon-block">
	          <a href="<?php echo get_term_link($tag_obj->term_id, 'rlisting_tags');
        ?>">
	            <div class="icon-box-round">
	              <i class="fa fa-tag" aria-hidden="true"></i>
	            </div>
	            <div class="icon-box-text">
	              <?php echo ucfirst($tag_obj->name); ?>
	            </div>
	          </a>
	        </div>
	      </li>
	      <?php
}
    ?>
	    </ul>
	  </div>
	</div>
	<?php
}