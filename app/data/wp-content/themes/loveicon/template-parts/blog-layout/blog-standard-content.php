<?php
$post_thumb_class = 'no-post-thumb';
if ( has_post_thumbnail() ) :
	$post_thumb_class = '';
endif;
$is_sticky_class = '';
if ( is_sticky() ) :
	$is_sticky_class = 'sticky-post-class';
endif;
$the_title_content    = get_the_title();
$the_title_class_have = 'have-title-post';
if ( $the_title_content != '' ) :
	$the_title_class_have = '';
endif;
?>


<div class="single-blog-style1 single-blog-style2 <?php echo esc_attr( $the_title_class_have . ' ' . $post_thumb_class . ' ' . $is_sticky_class ); ?>">
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		if ( is_sticky() ) {
			echo '<div class="sticky_post_icon " title="' . esc_attr__( 'Sticky Post', 'loveicon' ) . '"><i class="fa fa-map-pin"></i></div>';
		}
		?>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="img-holder">
				<div class="inner">
					<?php loveicon_post_thumbnail(); ?>
					<div class="overlay-icon">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><span class="flaticon-plus"></span></a>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="text-holder">
			<?php loveicon_category_list(); ?>
			<?php
			if ( is_singular() ) :
				the_title( '<h3 class="entry-title blog-title">', '</h3>' );
				else :
					the_title( '<h3 class="entry-title blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				endif;
				?>
			<div class="meta-box">
				<?php $loveicon_avatar_url = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 'full' ) ); ?>
				<div class="author-thumb">
					<img src="<?php echo esc_url( $loveicon_avatar_url ); ?>" alt="<?php esc_attr_e( 'avatar', 'loveicon' ); ?>">
				</div>
				<ul class="meta-info">
					<li><?php loveicon_posted_by(); ?></li>
					<li><i class="fa fa-calendar" aria-hidden="true"></i> <?php loveicon_posted_on(); ?></li>
					<li><i class="fa fa-comment-o" aria-hidden="true"></i><?php loveicon_comments_count(); ?></li>
				</ul>
			</div>
			<div class="text">
				<?php if ( ! empty( get_the_excerpt() ) ) : ?>
					<?php
					if ( get_option( 'rss_use_excerpt' ) ) {
						the_excerpt();
					} else {
						the_excerpt();
					}
					?>
				<?php endif; ?>
			</div>
			<div class="btns-box">
				<a class="btn-one" href="<?php echo esc_url( get_permalink() ); ?>">
					<span class="txt"><i class="arrow1 fa fa-check-circle"></i><?php echo esc_html__( 'Read More', 'loveicon' ); ?></span>
				</a>
			</div>
		</div> 
	</div> 
</div>
