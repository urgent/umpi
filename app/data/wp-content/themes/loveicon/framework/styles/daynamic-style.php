<?php
function loveicon_daynamic_styles() {
	ob_start();
	$loveicon_daynamic_styles_array = array();
	if ( is_page() ) {
		$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		if ( $featured_img_url ) {
			$page_breadcrumb_bg               = '
                .page-breadcrumb {
                    background-image: url(' . esc_url( $featured_img_url ) . ');
                }
                ';
			$loveicon_daynamic_styles_array[] = $page_breadcrumb_bg;
		}
	}
	if ( ( get_post_type() == 'campaign' ) && is_single() ) {
		$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		if ( $featured_img_url ) {
			$page_breadcrumb_bg               = '
                .campaign-single-breadcrumb {
                    background-image: url(' . esc_url( $featured_img_url ) . ');
                }
                ';
			$loveicon_daynamic_styles_array[] = $page_breadcrumb_bg;
		}
	}
	if ( ( get_post_type() == 'tribe_events' ) && is_single() ) {
		$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		if ( $featured_img_url ) {
			$page_breadcrumb_bg               = '
                .tribe_events-single-breadcrumb {
                    background-image: url(' . esc_url( $featured_img_url ) . ');
                }
                ';
			$loveicon_daynamic_styles_array[] = $page_breadcrumb_bg;
		}
	}
	$loveicon_daynamic_styles_array_expolord = implode( ' ', $loveicon_daynamic_styles_array );
	$loveicon_custom_css                     = ob_get_clean();
	return $loveicon_daynamic_styles_array_expolord;
}



function loveicon_get_custom_styles() {

	global $loveicon_options;
	$redix_opt_prefix = 'loveicon_';

	if ( ( isset( $loveicon_options[ $redix_opt_prefix . 'main_color' ] ) ) && ( ! empty( $loveicon_options[ $redix_opt_prefix . 'main_color' ] ) ) ) {
		$loveicon_main_color = $loveicon_options[ $redix_opt_prefix . 'main_color' ];
	}

	ob_start();
	if ( ( isset( $loveicon_options[ $redix_opt_prefix . 'main_color' ] ) ) && ( ! empty( $loveicon_options[ $redix_opt_prefix . 'main_color' ] ) ) ) {
		?>

/* template-color */

:root {
	--thm-primary: <?php echo esc_attr( $loveicon_main_color ); ?>;
}

		<?php
	}

	$loveicon_custom_css = ob_get_clean();

	return $loveicon_custom_css;
}

