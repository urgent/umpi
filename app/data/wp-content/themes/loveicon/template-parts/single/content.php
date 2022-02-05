<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package loveicon
 */

	$blog_single_social      = loveicon_get_options( 'blog_single_social' );
	$single_post_thumb_class = 'no-single-post-thumb';
if ( has_post_thumbnail() ) :
	$single_post_thumb_class = '';
	endif;
	$the_title_content    = get_the_title();
	$the_title_class_have = 'have-title-post';
if ( $the_title_content != '' ) :
	$the_title_class_have = '';
	endif;
?>
<div class="blog-details-content custom-blog-sinlge <?php echo esc_attr( $single_post_thumb_class . ' ' . $the_title_class_have ); ?>">
	<div class="single-blog-style1 single-blog-style2">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="img-holder">
				<?php loveicon_post_thumbnail(); ?>
			</div>
		<?php endif; ?>
		<div class="text-holder">
			<?php loveicon_category_list(); ?>
			<div class="meta-box">
				<?php $loveicon_avatar_url = get_avatar_url(get_the_author_meta( 'ID' ), array('size' => 'full')); ?>
				<div class="author-thumb">
					<img src="<?php echo esc_url($loveicon_avatar_url); ?>" alt="<?php esc_attr_e( 'avatar', 'loveicon' ); ?>">
				</div>
				<ul class="meta-info">
					<li><?php loveicon_posted_by(); ?></li>
					<li><i class="fa fa-calendar" aria-hidden="true"></i> <?php loveicon_posted_on(); ?></li>
					<li><i class="fa fa-comment-o" aria-hidden="true"></i><?php loveicon_comments_count(); ?></li>
				</ul>
			</div>

			<div class="blog-details-text-area">
				<?php the_content(); ?>
			</div>
			<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links post-single-link">',
						'after'  => '</div>',
					)
				);
			?>
			<?php if( has_tag() != '' ) : ?>
				<div class="post-tag-share-box">
					<div class="tag-box">
						<ul>
							<li><?php loveicon_tag_list(); ?></li>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div> 
	</div>

	<?php
		do_action( 'loveicon_authore_box_ready' );
	?>
	<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
</div>