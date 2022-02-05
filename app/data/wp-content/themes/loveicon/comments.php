<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package loveicon
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
	<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
			$comment_close = '';
			if ( ! comments_open() ) :
				$comment_close = 'comment-close';
			endif;
			?>
			<div class="comments-box-one comments-area-rif-at  <?php echo esc_attr($comment_close); ?>">
				<div class="title">
					<h2>
						<?php
							$loveicon_comment_count = get_comments_number();
							if ('1' === $loveicon_comment_count) {
								printf(
										/* translators: 1: title. */
										esc_html__('One Comment', 'loveicon')
								);
							} else {
								printf(// WPCS: XSS OK.
										/* translators: 1: comment count number, 2: title. */
										esc_html(_nx('%1$s Comment', '%1$s Comments ', $loveicon_comment_count, 'comments title', 'loveicon'), 'loveicon'), number_format_i18n($loveicon_comment_count)
								);
							}
						?>
					</h2>
				</div>
				<?php
					if (have_comments()) :
						the_comments_navigation();
				?>
				<ul id="comment-detail-list" class="inner comment-detail-list-area">		
					<?php
						wp_list_comments(
							array(
								'style'      => 'ol',
								'callback'   => 'loveicon_comments',
								'short_ping' => true,
							)
						);
					?>
				</ul>
					<?php
						the_comments_navigation();
						// If comments are closed and there are comments, let's leave a little note, shall we?
						if ( ! comments_open() ) :
							?>
							<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'loveicon' ); ?></p>
							<?php
						endif;
					endif;
				?>
			</div>
	<?php
		endif; // Check for have_comments().

	$is_no_post_thumb = '';
	if (!have_comments()) {
		$is_no_post_thumb = 'no-comment';
	}
	if ( comments_open() ) :
		$user = wp_get_current_user();
		$loveicon_user_identity = $user->display_name;
		$req = get_option('require_name_email');
		$aria_req = $req ? " aria-required='true'" : '';
		$formargs = array(
			'id_submit' => 'submit',
			'submit_field' => '<div class="row"><div class="col-sm-12 form-submit"><div class="button-box"><span class="txt">%1$s %2$s</span></div></div></div>',
			'title_reply' => esc_html__('Leave a Comment', 'loveicon'),
			'title_reply_to' => esc_html__('Leave a Comment to %s', 'loveicon'),
			'cancel_reply_link' => esc_html__('Cancel Reply', 'loveicon'),
			'title_reply_before' => '<div class="title"><h3 id="reply-title" class="comment-reply-title">',
			'title_reply_after' => '</h3></div>',
			'label_submit' => esc_html__('Submit now', 'loveicon'),
			'id_form' => 'review-form',
			'class_container' => 'reply-form-box ' . esc_attr($is_no_post_thumb),
			'comment_notes_before' => '',
			'submit_button' => '<button type="submit"  name="%1$s" id="%2$s" class="%3$s btn-one"><span class="txt"><i class="arrow1 fa fa-check-circle"></i>%4$s</span></button>',
			'comment_field' => '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12 form-group"><div class="input-box"><textarea id="comment" class="form-control" name="comment" placeholder="' . esc_attr__('Write your comment', 'loveicon') . '"  >' .
			'</textarea><div class="icon"><span class="fa fa-pencil"></span></div></div></div></div>',
			'must_log_in' => '<div>' . sprintf( wp_kses(__('You must be <a href="%s">logged in</a> to post a comment.', 'loveicon'), array('a' => array('href' => array()))), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</div>',
			'logged_in_as' => '<div class="logged-in-as">' . sprintf( wp_kses(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="%4$s">Log out?</a>', 'loveicon'), array('a' => array('href' => array()))), esc_url(admin_url('profile.php')), $loveicon_user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink())), esc_attr__('Log out of this account', 'loveicon')) . '</div>',
			'comment_notes_after' => '',
			'fields' => apply_filters('comment_form_default_fields', array(
				'author' =>
				'<div class="row full-name"><div class="col-lg-6 col-md-6 col-sm-12  form-group">'
				. '<div class="input-box"><input id="author" class="form-control" name="author" placeholder="' . esc_attr__('Full Name', 'loveicon') . '" type="text" value="' . esc_attr($commenter['comment_author']) .
				'" size="30"' . $aria_req . ' /><div class="icon"><span class="flaticon-user"></span></div></div></div>',
				'email' =>
				'<div class="col-lg-6 col-md-6 col-sm-12  form-group">'
				. '<div class="input-box"><input id="email" class="form-control"  name="email" type="text"  placeholder="' . esc_attr__('Email address', 'loveicon') . '" value="' . esc_attr($commenter['comment_author_email']) .
				'" size="30"' . $aria_req . ' /><div class="icon"><span class="flaticon-opened"></span></div></div></div></div>'
					)
			),
		);
		comment_form($formargs);
	endif;