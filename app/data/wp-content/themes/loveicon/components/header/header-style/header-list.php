<?php
$header_menu_style                   = loveicon_get_options( 'header_menu_style' );
$loveicon_theme_metabox_header_style = get_post_meta( get_the_ID(), 'loveicon_theme_metabox_header_style', true );

if ( $loveicon_theme_metabox_header_style != '' ) :
	if ( $loveicon_theme_metabox_header_style == 1 ) :
		get_template_part( 'components/header/header-style/header-style-one' );
		elseif ( $loveicon_theme_metabox_header_style == 2 ) :
			get_template_part( 'components/header/header-style/header-style-two' );
		elseif ( $loveicon_theme_metabox_header_style == 3 ) :
			get_template_part( 'components/header/header-style/header-style-three' );
		elseif ( $loveicon_theme_metabox_header_style == 4 ) :
			get_template_part( 'components/header/header-style/header-style-four' );
		elseif ( $loveicon_theme_metabox_header_style == 5 ) :
			get_template_part( 'components/header/header-style/header-style-five' );
		else :
			get_template_part( 'components/header/header-style/header-style-default' );
		endif;
	else :
		if ( $header_menu_style == 1 ) :
			get_template_part( 'components/header/header-style/header-style-one' );
		elseif ( $header_menu_style == 2 ) :
			get_template_part( 'components/header/header-style/header-style-two' );
		elseif ( $header_menu_style == 3 ) :
			get_template_part( 'components/header/header-style/header-style-three' );
		elseif ( $header_menu_style == 4 ) :
			get_template_part( 'components/header/header-style/header-style-four' );
		elseif ( $header_menu_style == 5 ) :
			get_template_part( 'components/header/header-style/header-style-five' );
		else :
			get_template_part( 'components/header/header-style/header-style-default' );
		endif;
	endif;
