<?php
/**
* The header for our theme.
*
* @package steemtemplates
*/
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[if IE 7]>
<style type="text/css" media="screen">
#stt_vmenu_items  li.stt_vmenu_items_parent {display:inline;}
</style>
<![endif]-->
<style>
.stt_comment_author{width : <?php echo steemtemplates_theme_option('ttr_avatar_size')."px";?>;}
<?php $avtar = steemtemplates_theme_option('ttr_avatar_size') + 10;?>
.stt_comment_text{width :calc(100% - <?php echo $avtar."px"?>);}
</style>
<?php wp_head(); ?>
</head>
<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
global $steemtemplates_cssprefix;
$theme_path_content = get_template_directory_uri().'/content';
$pageClass = strtolower(preg_replace('/_page.php$/', '', get_page_template_slug()));
if(empty($pageClass) && is_home() || is_single() || is_category() || is_archive() || is_search()){$pageClass = "blog-wp";
}
if (strrchr($pageClass, '/')) {
$pageClass = substr(strrchr($pageClass, '/'), 1);
}
?>
<body <?php body_class($pageClass); ?>> 
<?php if (steemtemplates_theme_option('ttr_back_to_top')): ?>
<?php $gotopng = steemtemplates_theme_option('ttr_icon_back_to_top');?>
<div class="totopshow">
<?php if(!empty($gotopng)): ?>
<a href="#" class="back-to-top">
<img alt="<?php esc_attr_e('Back to Top', 'BlockTradesAffiliatesV1'); ?>" src="<?php echo esc_url($gotopng); ?>">
</a>
<?php else : ?>
<a href="#" class="back-to-top">
<img alt="<?php esc_attr_e('Back to Top', 'BlockTradesAffiliatesV1'); ?>" src="<?php echo get_template_directory_uri().'/images/gototop0.png';?>">
</a>
<?php endif; ?>
</div>
<?php endif; ?>
<div id="stt_page" class="container">
<div class="stt_banner_menu">
<?php
if( is_active_sidebar( 'menuabovecolumn1'  ) || is_active_sidebar( 'menuabovecolumn2'  ) || is_active_sidebar( 'menuabovecolumn3'  ) || is_active_sidebar( 'menuabovecolumn4'  )):
?>
<div class="stt_banner_menu_inner_above_widget_container">
<div class="stt_banner_menu_inner_above0">
<?php if ( is_active_sidebar('menuabovecolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'MAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('menuabovecolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'MAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('menuabovecolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'MAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('menuabovecolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menuabovecolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'MAWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-lg-block visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
</div>
</div>
<div style="clear: both;"></div>
<?php endif; ?>
</div>
<div class="remove_collapsing_margins"></div>
<?php if ( has_nav_menu( 'primary' ) ) : ?>
<div class="navigation-top">
<div class="wrap">
<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
</div><!-- .wrap -->
</div><!-- .navigation-top -->
<?php endif; ?>
<div class="stt_banner_menu">
<?php
if( is_active_sidebar( 'menubelowcolumn1'  ) || is_active_sidebar( 'menubelowcolumn2'  ) || is_active_sidebar( 'menubelowcolumn3'  ) || is_active_sidebar( 'menubelowcolumn4'  )):
?>
<div class="stt_banner_menu_inner_below_widget_container">
<div class="stt_banner_menu_inner_below0">
<?php if ( is_active_sidebar('menubelowcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'MBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('menubelowcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'MBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('menubelowcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'MBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('menubelowcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="menubelowcolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'MBWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-lg-block visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
</div>
</div>
<div style="clear: both;"></div>
<?php endif; ?>
</div>
<div class="stt_banner_header">
<?php
if( is_active_sidebar( 'headerabovecolumn1'  ) || is_active_sidebar( 'headerabovecolumn2'  ) || is_active_sidebar( 'headerabovecolumn3'  ) || is_active_sidebar( 'headerabovecolumn4'  )):
?>
<div class="stt_banner_header_inner_above_widget_container">
<div class="stt_banner_header_inner_above0">
<?php if ( is_active_sidebar('headerabovecolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'HAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('headerabovecolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'HAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('headerabovecolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'HAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('headerabovecolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerabovecolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'HAWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-lg-block visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
</div>
</div>
<div style="clear: both;"></div>
<?php endif; ?>
</div>
<div class="remove_collapsing_margins"></div>
<?php $postid = ( isset( $post->ID ) ? get_the_ID() : NULL );
$var = get_post_meta ( $postid, 'ttr_page_head_checkbox', true );
if ($var == "true" || $var == ""):?>
<header id="stt_header">
<div class="stt_video_container">
<div id="stt_header_inner">
<div class="stt_header_element_alignment container">
</div>
<div class="headerforeground01">
</div>
<div class="stt_header_logo">
<span class="stt_header_logo_text">BLOCK EXCHANGE</span>
</div>
</div>
</header>
<?php endif; ?>
<div class="stt_banner_header">
<?php
if( is_active_sidebar( 'headerbelowcolumn1'  ) || is_active_sidebar( 'headerbelowcolumn2'  ) || is_active_sidebar( 'headerbelowcolumn3'  ) || is_active_sidebar( 'headerbelowcolumn4'  )):
?>
<div class="stt_banner_header_inner_below_widget_container">
<div class="stt_banner_header_inner_below0">
<?php if ( is_active_sidebar('headerbelowcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'HBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('headerbelowcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'HBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('headerbelowcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'HBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('headerbelowcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="headerbelowcolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'HBWidgetArea03'); ?>
</div>
</div>
<?php else: ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-lg-block visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
</div>
</div>
<div style="clear: both;"></div>
<?php endif; ?>
</div>