<?php
$post_thumb_class = 'no-post-thumb';
if ( has_post_thumbnail() ) :
	$post_thumb_class = '';
endif;
$is_sticky_class = '';
if ( is_sticky() ) :
	$is_sticky_class = 'sticky_post_class';
endif;
	$blog_grid_date = loveicon_get_options( 'blog_grid_date' );
?>

<div class="col-xl-4 col-lg-4 <?php echo esc_attr( $post_thumb_class . ' ' . $is_sticky_class ); ?>">
	<div class="single-blog-style1 wow fadeInUp" data-wow-duration="1500ms">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="img-holder">
				<div class="inner">
					<?php the_post_thumbnail( 'loveicon-blog-grid' ); ?>
					<div class="overlay-icon">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><span class="flaticon-plus"></span></a>
					</div>
				</div>
				<div class="date-box style3">
					<p><?php loveicon_posted_on(); ?></p>
				</div>
			</div>
		<?php endif; ?>
		<div class="text-holder">
			<?php
			if ( is_singular() ) :
				the_title( '<h3 class="entry-title blog-title">', '</h3>' );
				else :
					the_title( '<h3 class="entry-title blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				endif;
				?>
			<?php if ( ! empty( get_the_excerpt() ) ) : ?>
				<div class="text">
					<?php
					if ( get_option( 'rss_use_excerpt' ) ) {
						the_excerpt();
					} else {
						the_excerpt();
					}
					?>
				</div>
			<?php endif; ?>
			<ul class="meta-info">
				<li><i class="fa fa-user" aria-hidden="true"></i><?php loveicon_posted_by(); ?></li>
				<li><i class="fa fa-comment-o" aria-hidden="true"></i><?php loveicon_comments_count(); ?></li>
			</ul>
		</div> 
	</div>
</div>
