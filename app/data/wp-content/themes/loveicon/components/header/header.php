<?php
$header_menu_style                   = loveicon_get_options( 'header_menu_style' );
$loveicon_theme_metabox_header_style = get_post_meta( get_the_ID(), 'loveicon_theme_metabox_header_style', true );

$header_menu_class = 'base-header header-style-one';
if ( $loveicon_theme_metabox_header_style != '' ) :
	if ( $loveicon_theme_metabox_header_style == 1 ) :
		$header_menu_class = 'header-style-one';
	elseif ( $loveicon_theme_metabox_header_style == 2 ) :
		$header_menu_class = 'header-style-two';
	elseif ( $loveicon_theme_metabox_header_style == 3 ) :
		$header_menu_class = 'header-style-three';
	elseif ( $loveicon_theme_metabox_header_style == 4 ) :
		$header_menu_class = 'header-style-four';
	elseif ( $loveicon_theme_metabox_header_style == 5 ) :
		$header_menu_class = 'header-style-five';
	else :
		$header_menu_class = 'base-header header-style-one';
	endif;
else :
	if ( $header_menu_style == 1 ) :
		$header_menu_class = 'header-style-one';
	elseif ( $header_menu_style == 2 ) :
		$header_menu_class = 'header-style-two';
	elseif ( $header_menu_style == 3 ) :
		$header_menu_class = 'header-style-three';
	elseif ( $header_menu_style == 4 ) :
		$header_menu_class = 'header-style-four';
	elseif ( $header_menu_style == 5 ) :
		$header_menu_class = 'header-style-five';
	else :
		$header_menu_class = 'base-header header-style-one';
	endif;
endif;
?>
<header class="main-header <?php echo esc_attr( $header_menu_class ); ?>">
	<?php
		get_template_part( 'components/header/header-topbar/header-topbar-list' );
		get_template_part( 'components/header/header-style/header-list' );
		do_action( 'loveicon_sticky_header_ready' );
		do_action( 'loveicon_mobile_menu_ready' );
	?>
</header>
