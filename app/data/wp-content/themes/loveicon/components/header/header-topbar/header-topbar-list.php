<?php
$header_top_style                           = loveicon_get_options( 'header_top_style' );
$loveicon_theme_metabox_header_top_barstyle = get_post_meta( get_the_ID(), 'loveicon_theme_metabox_header_top_barstyle', true );

if ( $loveicon_theme_metabox_header_top_barstyle != '' ) :
	if ( $loveicon_theme_metabox_header_top_barstyle == 1 ) :
		get_template_part( 'components/header/header-topbar/header-topbar-one' );
		elseif ( $loveicon_theme_metabox_header_top_barstyle == 2 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-two' );
		elseif ( $loveicon_theme_metabox_header_top_barstyle == 3 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-three' );
		elseif ( $loveicon_theme_metabox_header_top_barstyle == 4 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-four' );
		elseif ( $loveicon_theme_metabox_header_top_barstyle == 5 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-off' );
		endif;
	else :
		if ( $header_top_style == 1 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-one' );
		elseif ( $header_top_style == 2 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-two' );
		elseif ( $header_top_style == 3 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-three' );
		elseif ( $header_top_style == 4 ) :
			get_template_part( 'components/header/header-topbar/header-topbar-four' );
		endif;
	endif;
