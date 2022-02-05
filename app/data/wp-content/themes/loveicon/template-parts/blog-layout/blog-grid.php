<?php
$blog_breadcrumb_class  = 'blog-breadcrumb-active';
$blog_breadcrumb_switch = loveicon_get_options( 'blog_breadcrumb_switch' );
if ( $blog_breadcrumb_switch == 1 ) :
	$blog_breadcrumb_class = '';
endif;
?>

<section class="blog-page-one <?php echo esc_attr( $blog_breadcrumb_class ); ?>">
	<div class="container">
		<div class="row text-right-rtl">
			<?php
			if ( have_posts() ) :

				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/blog-layout/blog-grid-content' );

					endwhile;
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
		</div>
		<?php if ( get_the_posts_pagination() ) : ?>
			<div class="row">
				<div class="col-xl-12">
					<?php
						the_posts_pagination(
							array(
								'mid_size'  => 2,
								'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
								'next_text' => '<i class="fa fa-long-arrow-right"></i>',

							)
						);
					?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</section>
