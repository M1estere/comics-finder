<?php
/**
 * Dynamyc CSS
 * Used to display Theme CSS options
 */
global $parameters;

$css = '';
// Layout
if ( isset( $parameters['container_width'] ) && $parameters['container_width'] ) :
	$css .= sprintf( '.container {max-width: %spx } ', $parameters['container_width'] );
	$css .= sprintf( '.site.vertical {max-width: %spx } ', $parameters['container_width'] );
	$css .= sprintf( 'body {--wp--style--global--content-size: %spx} ', $parameters['container_width'] );
else :
	$css .= sprintf( '.container {max-width: %spx } ', '1240' );
endif;

if ( isset( $parameters['scrollbar'] ) && $parameters['scrollbar'] ) :
	$css .= sprintf( 'html {scrollbar-gutter:%s } ', $parameters['scrollbar'] );
endif;

if ( isset( $parameters['body_color'] ) && $parameters['body_color'] ) :
	if ( strlen( $parameters['body_color'] ) <= 6 ) :
		$prefix1 = '#';
	else :
		$prefix1 = '';
	endif;
	$css .= sprintf( 'body{ background-color: %s%s } ', $prefix1, $parameters['body_color'] );
endif;

if ( isset( $parameters['body_background'] ) && $parameters['body_background'] ) :
	$css .= sprintf( ".site {background-image:url('%s') } ", $parameters['body_background'] );
endif;


if ( isset( $parameters['main_font_color'] ) && $parameters['main_font_color'] ) :
	if ( strlen( $parameters['main_font_color'] ) <= 6 ) :
		$prefix3 = '#';
	else :
		$prefix3 = '';
	endif;
	$css .= sprintf( 'body{color: %s%s } ', $prefix3, $parameters['main_font_color'] );
	$css .= sprintf( 'body{--preset--font-color: %s%s } ', $prefix3, $parameters['main_font_color'] );
endif;

if ( isset( $parameters['link_color'] ) && $parameters['link_color'] ) :
	if ( strlen( $parameters['link_color'] ) <= 6 ) :
		$prefix4 = '#';
	else :
		$prefix4 = '';
	endif;
	$css .= sprintf( '.site .content-area a:not(.btn, .wp-block-button__link, .header__brand){color: %s%s } ', $prefix4, $parameters['link_color'] );
	$css .= sprintf( 'body{--preset--secondary-color: %s%s } ', $prefix4, $parameters['link_color'] );
endif;

if ( isset( $parameters['link_color_hover'] ) && $parameters['link_color_hover'] ) :
	if ( strlen( $parameters['link_color_hover'] ) <= 6 ) :
		$prefix5 = '#';
	else :
		$prefix5 = '';
	endif;
	$css .= sprintf( '.site a:hover{color: %s%s!important} ', $prefix5, $parameters['link_color_hover'] );
	$css .= sprintf( 'body{--preset--tertiary-color: %s%s } ', $prefix5, $parameters['link_color_hover'] );
endif;

if ( isset( $parameters['main_font'] ) && $parameters['main_font'] ) :
	$css .= sprintf( 'body {font-family:%s, %s } ', $parameters['main_font'], 'sans-serif' );
endif;

if ( isset( $parameters['main_font_size'] ) && $parameters['main_font_size'] ) :
	$css .= sprintf( '.site .site-content p {font-size:%s%s} ', $parameters['main_font_size'], 'px' );
	$css .= sprintf( '.site .site-content ul {font-size:%s%s} ', $parameters['main_font_size'], 'px' );
	$css .= sprintf( '.site .site-content li {font-size:%s%s} ', $parameters['main_font_size'], 'px' );
	$css .= sprintf( '.site .site-content span {font-size:%s%s} ', $parameters['main_font_size'], 'px' );
	$css .= sprintf( '.site .site-content a {font-size:%s%s} ', $parameters['main_font_size'], 'px' );
	$css .= sprintf( '.site .site-content {font-size:%s%s} ', $parameters['main_font_size'], 'px' );
endif;

if ( isset( $parameters['main_font_size_tablet'] ) && $parameters['main_font_size_tablet'] ) :
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content p {font-size:%s%s} }', $parameters['main_font_size_tablet'], 'px' );
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content ul {font-size:%s%s} }', $parameters['main_font_size_tablet'], 'px' );
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content li {font-size:%s%s} }', $parameters['main_font_size_tablet'], 'px' );
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content span {font-size:%s%s} }', $parameters['main_font_size_tablet'], 'px' );
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content a {font-size:%s%s} }', $parameters['main_font_size_tablet'], 'px' );
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content {font-size:%s%s} }', $parameters['main_font_size_tablet'], 'px' );

endif;

if ( isset( $parameters['main_font_size_mobile'] ) && $parameters['main_font_size_mobile'] ) :
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content p {font-size:%s%s} }', $parameters['main_font_size_mobile'], 'px' );
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content ul {font-size:%s%s} }', $parameters['main_font_size_mobile'], 'px' );
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content li {font-size:%s%s} }', $parameters['main_font_size_mobile'], 'px' );
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content span {font-size:%s%s} }', $parameters['main_font_size_mobile'], 'px' );
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content a {font-size:%s%s} }', $parameters['main_font_size_mobile'], 'px' );
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content {font-size:%s%s} }', $parameters['main_font_size_mobile'], 'px' );

endif;

if ( isset( $parameters['main_font_weight'] ) && $parameters['main_font_weight'] ) :
	$css .= sprintf( '.site .site-content p {font-weight:%s} ', $parameters['main_font_weight'] );
	$css .= sprintf( '.site .site-content ul {font-weight:%s} ', $parameters['main_font_weight'] );
	$css .= sprintf( '.site .site-content li {font-weight:%s} ', $parameters['main_font_weight'] );
	$css .= sprintf( '.site .site-content span {font-weight:%s} ', $parameters['main_font_weight'] );
	$css .= sprintf( '.site .site-content a {font-weight:%s} ', $parameters['main_font_weight'] );
	$css .= sprintf( '.site .site-content {font-weight:%s} ', $parameters['main_font_weight'] );
	$css .= sprintf( 'body {font-weight:%s} ', $parameters['main_font_weight'] );
endif;

if ( isset( $parameters['main_font_style'] ) && $parameters['main_font_style'] ) :
	$css .= sprintf( '.site .site-content p {font-style:%s} ', $parameters['main_font_style'] );
	$css .= sprintf( '.site .site-content ul {font-style:%s} ', $parameters['main_font_style'] );
	$css .= sprintf( '.site .site-content li {font-style:%s} ', $parameters['main_font_style'] );
	$css .= sprintf( '.site .site-content span {font-style:%s} ', $parameters['main_font_style'] );
	$css .= sprintf( '.site .site-content a {font-style:%s} ', $parameters['main_font_style'] );
	$css .= sprintf( '.site .site-content {font-style:%s} ', $parameters['main_font_style'] );
endif;

if ( isset( $parameters['main_font_line'] ) && $parameters['main_font_line'] ) :
	$css .= sprintf( 'body {line-height:%s} ', $parameters['main_font_line'] );
endif;

if ( isset( $parameters['main_font_spacing'] ) && $parameters['main_font_spacing'] ) :
	$css .= sprintf( 'body {letter-spacing:%s%s} ', $parameters['main_font_spacing'], 'px' );
endif;

if ( isset( $parameters['main_font_link_decoration'] ) && $parameters['main_font_link_decoration'] ) :
	$css .= sprintf( '.site .site-content a:not(.btn, .wp-block-button__link) {text-decoration:%s} ', $parameters['main_font_link_decoration'] );
endif;

if ( isset( $parameters['h6_size_tablet'] ) && $parameters['h6_size_tablet'] ) :
	$css .= sprintf( '@media(max-width: 1120px) { .site .site-content h6 {font-size:%s%s} }', $parameters['h6_size_tablet'], 'px' );
endif;

if ( isset( $parameters['h6_size_mobile'] ) && $parameters['h6_size_mobile'] ) :
	$css .= sprintf( '@media(max-width: 767px) { .site .site-content h6 {font-size:%s%s} } ', $parameters['h6_size_mobile'], 'px' );
endif;


if ( isset( $parameters['logo_width'] ) && $parameters['logo_width'] ) :
	$css .= sprintf( '.site .custom-logo-link .img-fluid {width:%s%s} ', $parameters['logo_width'], 'px' );
	$css .= sprintf( '.site .custom-logo-link .img-fluid {max-height:%s} ', 'none' );
endif;

if ( isset( $parameters['header_background'] ) && $parameters['header_background'] ) :
	if ( strlen( $parameters['header_background'] ) <= 6 ) :
		$prefix6 = '#';
	else :
		$prefix6 = '';
	endif;
	$css .= sprintf( '.header {background: %s%s } ', $prefix6, $parameters['header_background'] );
endif;

if ( isset( $parameters['header_color'] ) && $parameters['header_color'] ) :
	if ( strlen( $parameters['header_color'] ) <= 6 ) :
		$prefix7 = '#';
	else :
		$prefix7 = '';
	endif;
	$css .= sprintf( '.header ul li .nav__link {color: %s%s } ', $prefix7, $parameters['header_color'] );
	$css .= sprintf( '.header .socials__icon {color: %s%s } ', $prefix7, $parameters['header_color'] );
	$css .= sprintf( '.header .header__brand {color: %s%s } ', $prefix7, $parameters['header_color'] );
endif;

if ( isset( $parameters['header_color_hover'] ) && $parameters['header_color_hover'] ) :
	if ( strlen( $parameters['header_color_hover'] ) <= 6 ) :
		$prefix8 = '#';
	else :
		$prefix8 = '';
	endif;
	$css .= sprintf( '.site .menu-main-container .nav__link:hover {color: %s%s!important} ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.site .menu-main-container .nav__link:after, .posts-ajax__tab span:after {border-color: %s%s !important} ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.site .menu-main-container .current-menu-item > .nav__link {color: %s%s!important} ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.header .header__brand:hover {color: %s%s } ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.posts-ajax__tab.checked {color: %s%s } ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.posts-ajax__tab:hover {color: %s%s } ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.posts__tab.checked {color: %s%s } ', $prefix8, $parameters['header_color_hover'] );
	$css .= sprintf( '.posts__tab:hover {color: %s%s } ', $prefix8, $parameters['header_color_hover'] );
endif;

if ( isset( $parameters['submenu_background'] ) && $parameters['submenu_background'] ) :
	if ( strlen( $parameters['submenu_background'] ) <= 6 ) :
		$prefix81 = '#';
	else :
		$prefix81 = '';
	endif;
	$css .= sprintf( '.site .menu-main-container .header__submenu-wrap {background-color: %s%s } ', $prefix81, $parameters['submenu_background'] );
endif;

if ( isset( $parameters['submenu_color'] ) && $parameters['submenu_color'] ) :
	if ( strlen( $parameters['submenu_color'] ) <= 6 ) :
		$prefix82 = '#';
	else :
		$prefix82 = '';
	endif;
	$css .= sprintf( '.site .menu-main-container .header__submenu-wrap .menu__submenu--depth-1 li a {color: %s%s } ', $prefix82, $parameters['submenu_color'] );
endif;

if ( isset( $parameters['submenu_color_hover'] ) && $parameters['submenu_color_hover'] ) :
	if ( strlen( $parameters['submenu_color_hover'] ) <= 6 ) :
		$prefix83 = '#';
	else :
		$prefix83 = '';
	endif;
	$css .= sprintf( '.site .menu-main-container .header__submenu-wrap .menu__submenu--depth-1 li a:hover {color: %s%s } ', $prefix83, $parameters['submenu_color_hover'] );
	$css .= sprintf( '.site .menu-main-container .header__submenu-wrap .menu__submenu--depth-1 li a:after {border-color: %s%s } ', $prefix83, $parameters['submenu_color_hover'] );
endif;

if ( isset( $parameters['header_text_weight'] ) && $parameters['header_text_weight'] ) :
	$css .= sprintf( 'body .menu-main-container > .current-menu-item > .nav__link {font-weight:%s} ', $parameters['header_text_weight'] );
endif;

if ( isset( $parameters['header_text_font_size'] ) && $parameters['header_text_font_size'] ) :
	$css .= sprintf( 'body .menu-main-container .nav__link {font-size:%s%s} ', $parameters['header_text_font_size'], 'px' );
	$css .= sprintf( '.posts-ajax__tab span {font-size: %s%s } ', $parameters['header_text_font_size'], 'px' );
endif;

if ( isset( $parameters['submenu_font_size'] ) && $parameters['submenu_font_size'] ) :
	$css .= sprintf( '.site .menu-main-container .header__submenu-wrap .menu__submenu--depth-1 li a {font-size:%s%s} ', $parameters['submenu_font_size'], 'px' );
endif;

if ( isset( $parameters['header_text_font_style'] ) && $parameters['header_text_font_style'] ) :
	$css .= sprintf( 'body .menu-main-container .nav__link {font-style:%s} ', $parameters['header_text_font_style'] );
endif;

if ( isset( $parameters['header_text_font_spacing'] ) && $parameters['header_text_font_spacing'] ) :
	$css .= sprintf( 'body .menu-main-container .nav__link {letter-spacing:%s%s} ', $parameters['header_text_font_spacing'], 'px' );
endif;

if ( isset( $parameters['header_fixed_background'] ) && $parameters['header_fixed_background'] ) :
	if ( strlen( $parameters['header_fixed_background'] ) <= 6 ) :
		$prefix9 = '#';
	else :
		$prefix9 = '';
	endif;
	$css .= sprintf( '.header.header__fixed.active {background: %s%s } ', $prefix9, $parameters['header_fixed_background'] );
endif;

if ( isset( $parameters['header_fixed_color'] ) && $parameters['header_fixed_color'] ) :
	if ( strlen( $parameters['header_fixed_color'] ) <= 6 ) :
		$prefix10 = '#';
	else :
		$prefix10 = '';
	endif;
	$css .= sprintf( '.header.header__fixed.active ul li .nav__link {color: %s%s } ', $prefix10, $parameters['header_fixed_color'] );
endif;

if ( isset( $parameters['header_fixed_color_hover'] ) && $parameters['header_fixed_color_hover'] ) :
	if ( strlen( $parameters['header_fixed_color_hover'] ) <= 6 ) :
		$prefix11 = '#';
	else :
		$prefix11 = '';
	endif;
	$css .= sprintf( 'body .header.header__fixed.active .menu-main-container .nav__link:hover {color: %s%s} ', $prefix11, $parameters['header_fixed_color_hover'] );
	$css .= sprintf( 'body .header.header__fixed.active .menu-main-container .nav__link:hover {color: %s%s} ', $prefix11, $parameters['header_fixed_color_hover'] );
	$css .= sprintf( 'body .header.header__fixed.active .menu-main-container .nav__link:after {border-color: %s%s} ', $prefix11, $parameters['header_fixed_color_hover'] );
	$css .= sprintf( 'body .header.header__fixed.active .menu-main-container .current-menu-item .nav__link {color: %s%s} ', $prefix11, $parameters['header_fixed_color_hover'] );
	$css .= sprintf( 'body .header.header__fixed.active .menu-main-container .current-menu-item .nav__link {color: %s%s} ', $prefix11, $parameters['header_fixed_color_hover'] );
endif;

if ( isset( $parameters['blog_hover_color'] ) && $parameters['blog_hover_color'] ) :
	if ( strlen( $parameters['blog_hover_color'] ) <= 6 ) :
		$prefix24 = '#';
	else :
		$prefix24 = '';
	endif;
	$css .= sprintf( '.blog-post-type .post-card__overlay {background-color: %s%s } ', $prefix24, $parameters['blog_hover_color'] );
endif;

if ( isset( $parameters['portfolio_hover_color'] ) && $parameters['portfolio_hover_color'] ) :
	if ( strlen( $parameters['portfolio_hover_color'] ) <= 6 ) :
		$prefix23 = '#';
	else :
		$prefix23 = '';
	endif;
	$css .= sprintf( '.portfolio-post-type .post-card__overlay {background-color: %s%s } ', $prefix23, $parameters['portfolio_hover_color'] );
endif;

if ( isset( $parameters['footer_background'] ) && $parameters['footer_background'] ) :
	if ( strlen( $parameters['footer_background'] ) <= 6 ) :
		$prefix21 = '#';
	else :
		$prefix21 = '';
	endif;
	$css .= sprintf( 'footer.minimalio-footer  {background-color: %s%s } ', $prefix21, $parameters['footer_background'] );
endif;

if ( isset( $parameters['footer_font_color'] ) && $parameters['footer_font_color'] ) :
	if ( strlen( $parameters['footer_font_color'] ) <= 6 ) :
		$prefix22 = '#';
	else :
		$prefix22 = '';
	endif;
	$css .= sprintf( 'footer:not(.entry-footer) * {color: %s%s } ', $prefix22, $parameters['footer_font_color'] );
endif;

if ( isset( $parameters['icons_bar_color'] ) && $parameters['icons_bar_color'] ) :
	if ( strlen( $parameters['icons_bar_color'] ) <= 6 ) :
		$prefix15 = '#';
	else :
		$prefix15 = '';
	endif;
	$css .= sprintf( '.site .header__mobile-button .mobile-menu__open-icon {color: %s%s !important } ', $prefix15, $parameters['icons_bar_color'] );
endif;


if ( isset( $parameters['breaking_point'] ) && $parameters['breaking_point'] ) :
	$css .= sprintf( '@media (min-width: %s%s) { .header__mobile-button {display:none}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (max-width: %s%s) { .header__mobile-button {display:block}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (min-width: %s%s) { .menu-main-container {display:block}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (max-width: %s%s) { .menu-main-container {display:none!important}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (min-width: %s%s) { .mobile-menu {display:none}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (max-width: %s%s) { .mobile-menu.is-active {display:block}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (min-width: %s%s) { .menu-main-container.centered {display:flex}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (max-width: %s%s) { .menu-main-container.centered {display:none}} ', $parameters['breaking_point'], 'px' );
	$css .= sprintf( '@media (max-width: %s%s) { .header__social-block {display:none}} ', $parameters['breaking_point'], 'px' );
else :
	$css .= sprintf( '@media (min-width: %s) { .header__mobile-button {display:none}} ', '768px' );
	$css .= sprintf( '@media (max-width: %s) { .header__mobile-button {display:block}} ', '768px' );
	$css .= sprintf( '@media (min-width: %s) { .menu-main-container {display:block}} ', '768px' );
	$css .= sprintf( '@media (max-width: %s) { .menu-main-container {display:none}} ', '768px' );
	$css .= sprintf( '@media (min-width: %s) { .mobile-menu {display:none}} ', '768px' );
	$css .= sprintf( '@media (max-width: %s) { .mobile-menu.is-active {display:block}} ', '768px' );
	$css .= sprintf( '@media (min-width: %s) { .menu-main-container.centered {display:flex}} ', '768px' );
	$css .= sprintf( '@media (max-width: %s) { .menu-main-container.centered {display:none}} ', '768px' );
	$css .= sprintf( '@media (max-width: %s) { .header__social-block {display:none}} ', '768px' );
endif;

if ( isset( $parameters['mobile_top_background'] ) && $parameters['mobile_top_background'] ) :
	if ( strlen( $parameters['mobile_top_background'] ) <= 6 ) :
		$prefix17 = '#';
	else :
		$prefix17 = '';
	endif;
	$css .= sprintf( '.mobile-menu__logo-wrap {background-color: %s%s } ', $prefix17, $parameters['mobile_top_background'] );
endif;

if ( isset( $parameters['mobile_background'] ) && $parameters['mobile_background'] ) :
	if ( strlen( $parameters['mobile_background'] ) <= 6 ) :
		$prefix18 = '#';
	else :
		$prefix18 = '';
	endif;
	$css .= sprintf( '.mobile-menu  {background-color: %s%s } ', $prefix18, $parameters['mobile_background'] );
endif;

if ( isset( $parameters['mobile_close_color'] ) && $parameters['mobile_close_color'] ) :
	if ( strlen( $parameters['mobile_close_color'] ) <= 6 ) :
		$prefix19 = '#';
	else :
		$prefix19 = '';
	endif;
	$css .= sprintf( '.site .header__mobile-button .mobile-menu__close-icon  {color: %s%s } ', $prefix19, $parameters['mobile_close_color'] );
	$css .= sprintf( '.site .header__mobile-button .mobile-menu__close-icon:hover {color: %s%s } ', $prefix19, $parameters['mobile_close_color'] );
endif;

if ( isset( $parameters['mobile_color'] ) && $parameters['mobile_color'] ) :
	if ( strlen( $parameters['mobile_color'] ) <= 6 ) :
		$prefix20 = '#';
	else :
		$prefix20 = '';
	endif;
	$css .= sprintf( '.mobile-menu__menu li .mobile-menu__link {color: %s%s } ', $prefix20, $parameters['mobile_color'] );
	$css .= sprintf( '.menu-item-has-children.mobile-menu__item::after {color: %s%s } ', $prefix20, $parameters['mobile_color'] );
	$css .= sprintf( '.mobile-menu__container-social a.socials__link svg {color: %s%s } ', $prefix20, $parameters['mobile_color'] );
endif;

if ( isset( $parameters['mobile_font_size'] ) && $parameters['mobile_font_size'] ) :
	$css .= sprintf( '.mobile-menu__menu li {font-size:%s%s} ', $parameters['mobile_font_size'], 'px' );
	$css .= sprintf( '.mobile-menu a.socials__link {width:%s%s} ', $parameters['mobile_font_size'], 'px' );
	$css .= sprintf( '.mobile-menu a.socials__link {height:%s%s} ', $parameters['mobile_font_size'], 'px' );
endif;

if ( isset( $parameters['mobile_font_style'] ) && $parameters['mobile_font_style'] ) :
	$css .= sprintf( '.mobile-menu__menu li a {font-style:%s} ', $parameters['mobile_font_style'] );
endif;

if ( isset( $parameters['mobile_font_spacing'] ) && $parameters['mobile_font_spacing'] ) :
	$css .= sprintf( '.mobile-menu__menu li a {letter-spacing:%s%s} ', $parameters['mobile_font_spacing'], 'px' );
endif;

if ( isset( $parameters['mobile_font_spacing'] ) && $parameters['mobile_font_spacing'] ) :
	$css .= sprintf( '.mobile-menu__menu li a {letter-spacing:%s%s} ', $parameters['mobile_font_spacing'], 'px' );
endif;

if ( isset( $parameters['lightbox_icons_color'] ) && $parameters['lightbox_icons_color'] ) :
	if ( strlen( $parameters['lightbox_icons_color'] ) <= 6 ) :
		$prefix25 = '#';
	else :
		$prefix25 = '';
	endif;
	$css .= sprintf( '.pswp--open svg * {fill: %s%s } ', $prefix25, $parameters['lightbox_icons_color'] );
	$css .= sprintf( '.pswp--open svg * {stroke: %s%s } ', $prefix25, $parameters['lightbox_icons_color'] );
	$css .= sprintf( '.pswp--open .pswp__counter {color: %s%s } ', $prefix25, $parameters['lightbox_icons_color'] );
endif;

return $css;
