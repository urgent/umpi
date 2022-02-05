<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package loveicon
 */

if ( ! function_exists( 'loveicon_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function loveicon_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( ' %s', 'post date', 'loveicon' ),
			'' . $time_string . ''
		);

		echo '' . $posted_on . '';

	}
endif;

if (!function_exists('loveicon_category_list')) :

    function loveicon_category_list() {
        if ('post' === get_post_type()) {
            $category_list = get_the_category_list(esc_html__(' ', 'loveicon'));
            if ($category_list) {
				?>
					<div class="categories">
				<?php
						printf($category_list); // WPCS: XSS OK.
				?>
					</div>
				<?php
            }
        }
    }

endif;

if (!function_exists('loveicon_tag_list')) :

    function loveicon_tag_list() {
        if ('post' === get_post_type()) {
            $tag_list = get_the_tag_list('', esc_html_x( ' ', 'list item separator', 'loveicon' ));
            if ($tag_list) {
                printf($tag_list); // WPCS: XSS OK.
            }
        }
    }

endif;


if ( ! function_exists( 'loveicon_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function loveicon_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'loveicon' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);
		echo '' . $byline . ''; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'loveicon_posted_by_auth' ) ) :
	/**
	 * Prints HTML with meta information for the current author by.
	 */
	function loveicon_posted_by_auth() {	
		global $post;
		$author_id = $post->post_author;
		$byline = sprintf(
			/* translators: %s: post author. */
			'<span>' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</span>'
		);
		echo '' . $byline . ''; // WPCS: XSS OK.

	}
endif;


if ( ! function_exists( 'loveicon_posted_by_2' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function loveicon_posted_by_2() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'loveicon' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);
		echo '' . $byline . ''; // WPCS: XSS OK.

	}
endif;
if (!function_exists('loveicon_comments_count')) :

    function loveicon_comments_count() {
        if (get_comments_number(get_the_ID()) == 0) {
            $comments_count = '<a href="' . esc_url(get_permalink()) . '" >' . get_comments_number(get_the_ID()) . " comments" . '</a>';
        }
        elseif (get_comments_number(get_the_ID()) > 1) {
            $comments_count = '<a href="' . esc_url(get_permalink()) . '" >' . get_comments_number(get_the_ID()) . " comments" . '</a>';
        } else {
            $comments_count = '<a href="' . esc_url(get_permalink()) . '#comments" >' . get_comments_number(get_the_ID()) . " comment" . '</a>';
        }
        echo sprintf(esc_html('%s'), $comments_count); // WPCS: XSS OK.
    }

endif;

if ( ! function_exists( 'loveicon_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function loveicon_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'loveicon' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'loveicon' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'loveicon' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'loveicon' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'loveicon' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'loveicon' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'loveicon_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function loveicon_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if ( is_singular() ) :
	?>
		<div class="image-box">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php else : ?>
		<div class="img-holder">
			<div class="inner">
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail( 'post-thumbnail', array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
					?>
				</a>
			</div>
		</div>
	<?php
		endif; // End is_singular().
	}
endif;






if (!function_exists('loveicon_comments')) {

    function loveicon_comments($comment, $args, $depth) {
        extract($args, EXTR_SKIP);
        $args['reply_text'] = esc_html__('Reply', 'loveicon');
        $class = '';
        if ($depth > 1) {
            $class = '';
        }
        if ($depth == 1) {
            $child_html_el = '<ul><li>';
            $child_html_end_el = '</li></ul>';
        }

        if ($depth >= 2) {
            $child_html_el = '<li>';
            $child_html_end_el = '</li>';
		}
		$comment_class_ping = 'yes-ping';
		if ($comment->comment_type != 'trackback' && $comment->comment_type != 'pingback') :
			$comment_class_ping = '';
		endif;
        ?>
        <li>
			<div class="single-comments-box single-comment <?php echo esc_attr($comment_class_ping); ?>" id="comment-<?php comment_ID(); ?>">
				<?php if ($comment->comment_type != 'trackback' && $comment->comment_type != 'pingback') { ?>
					<div class="img_box">
						<div class="inner">
							<?php print get_avatar($comment, 80, null, null, array('class' => array())); ?>
						</div>
					</div>
				<?php } ?>
				<div class="text_box">
					<div class="inner">
						<div class="top">
							<div class="left">
								<h4><?php echo get_comment_author(); ?></h4>
								<span><?php echo get_the_date(); ?></span>
							</div>
							<div class="right">
								<div class="btns-box">
									<?php 
										$replyBtn = 'btn-one';
										echo preg_replace( '/comment-reply-link/', 'comment-reply-link thm_clr1 ' . $replyBtn, 
											get_comment_reply_link(array_merge( $args, array(
												'reply_text' => '<span class="txt"><i class="arrow1 fa fa-check-circle"></i>' . esc_html__( 'Reply', 'loveicon' ) . '</span>',
												'depth' => $depth,
												'max_depth' => $args['max_depth']))), 1 
										); 
									?>
								</div>    
							</div>
						</div>
						<div class="text">
							<?php comment_text(); ?>
						</div>
					</div>
				</div>
			</div>
            <?php
        }
    }