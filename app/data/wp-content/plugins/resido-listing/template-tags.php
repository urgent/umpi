<?php
function resido_listings_template_path() {
	return apply_filters( 'resido_listings_template_path', 'listings/' );
}

function resido_listings_get_part( $slug, $name = null, $include = true ) {
	$template = "{$slug}.php";
	$name     = (string) $name;
	if ( '' !== $name ) {
		$template = "{$slug}-{$name}.php";
	}

	if ( $located = locate_template( 'resido-listings/' . $template ) ) {
		if ( $include ) {
			include $located;
		} else {
			return $located;
		}
	} else {
		if ( $include ) {
			include RESIDO_LISTING_PATH . '/templates/' . $template;
		} else {
			return RESIDO_LISTING_PATH . '/templates/' . $template;
		}
	}
}

function resido_get_listing_submit_form_part( $template_name ) {
	resido_listings_get_part( 'listing-submit-form/' . $template_name );
}

function resido_get_listing_loop_part( $template_name ) {
	resido_listings_get_part( 'loop/' . $template_name );
}

function resido_get_listing_single_part( $template_name ) {
	 resido_listings_get_part( 'single/' . $template_name );
}

function resido_get_listing_dashboard_part( $template_name ) {
	resido_listings_get_part( 'dashboard/' . $template_name );
}

/**
 * is_listing_archive - Returns true when viewing the listing type archive.
 */
if ( ! function_exists( 'is_listing_archive' ) ) {
	function is_listing_archive() {
		 return ( is_post_type_archive( 'rlisting' ) );
	}
}


function resido_user_share_opt() {
	$listing_option  = resido_listing_option();
	$share_facebook  = isset( $listing_option['share_facebook'] ) ? $listing_option['share_facebook'] : 1;
	$share_twitter   = isset( $listing_option['share_twitter'] ) ? $listing_option['share_twitter'] : 1;
	$share_linked_in = isset( $listing_option['share_instagram'] ) ? $listing_option['share_instagram'] : 1;

	$facebook  = 'http://www.facebook.com/sharer.php?u=' . get_the_permalink();
	$twitter   = 'http://twitter.com/home?status=' . get_the_title() . '  ' . get_the_permalink();
	$linked_in = 'http://linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . get_the_title();
	$telegram  = 'https://t.me/share/url?url=' . get_the_permalink() . '&text=' . get_the_title();
	$vk        = 'http://vk.com/share.php?url=' . get_the_permalink();
	?>
	<div class="social_share_panel">
		<?php
		if ( $listing_option['share_facebook'] ) {
			?>
			<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" class="cl-facebook"><i class="lni-facebook"></i></a>
			<?php
		}
		if ( $listing_option['share_twitter'] ) {
			?>
			<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" class="cl-twitter"><i class="lni-twitter"></i></a>
			<?php
		}
		if ( $listing_option['share_linked_in'] ) {
			?>
			<a href="<?php echo esc_url( $linked_in ); ?>" target="_blank" class="cl-linkedin"><i class="lni-linkedin"></i></a>
			<?php
		}
		if ( $listing_option['share_whatsapp'] ) {
			?>
			<a href="whatsapp://send?text=<?php echo get_the_permalink(); ?>" target="_blank"><i class="lni-whatsapp"></i></a>
			<?php
		}
		if ( $listing_option['share_telegram'] ) {
			?>
			<a href="<?php echo esc_url( $telegram ); ?>" target="_blank"><i class="lni-telegram"></i></a>
			<?php
		}
		if ( $listing_option['share_vk'] ) {
			?>
			<a href="<?php echo esc_url( $vk ); ?>" target="_blank"><i class="lni-vk"></i></a>
		<?php } ?>
	</div>

	<?php

}
