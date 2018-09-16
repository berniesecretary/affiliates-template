<?php
/**
* The template for displaying the footer.
*
* @package steemtemplates
*/
?>
<?php $theme_path = get_template_directory_uri(); 
$theme_path_content = get_template_directory_uri().'/content'; ?>
<div class="footer-widget-area" role="complementary">
<div class="footer-widget-area_inner">
<?php
if( is_active_sidebar( 'footerabovecolumn1'  ) || is_active_sidebar( 'footerabovecolumn2'  ) || is_active_sidebar( 'footerabovecolumn3'  ) || is_active_sidebar( 'footerabovecolumn4'  )):
?>
<div class="stt_footer-widget-area_inner_above_widget_container">
<div class="stt_footer-widget-area_inner_above0">
<?php if ( is_active_sidebar('footerabovecolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'FAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('footerabovecolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'FAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('footerabovecolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'FAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('footerabovecolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerabovecolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'FAWidgetArea03'); ?>
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
</div>
<div class="remove_collapsing_margins"></div>
<?php $postid = ( isset( $post->ID ) ? get_the_ID() : NULL );
$var = get_post_meta ( $postid, 'ttr_page_foot_checkbox', true );
if($var == "true" || $var == ""):?>
<footer id="stt_footer">
<div class="stt_footer_html_row0 row">
<div class="container">
</div>
</div>
<div id="stt_footer_top_for_widgets">
<div class="stt_footer_top_for_widgets_inner">
<?php get_sidebar( 'footer' ); ?>
</div>
</div>
<div class="stt_footer_bottom_footer">
<div class="stt_footer_bottom_footer_inner">
<div class="stt_footer_element_alignment container">
</div>
<div id="stt_footer_designed_by_links">
<?php $footer_designedbylink_URL = steemtemplates_theme_option('ttr_designedby_link_url'); 
$footer_designedby_link = steemtemplates_theme_option('ttr_designedby_link'); ?>
<?php $footer_link="http://SteemTemplates.com"?>
<?php  if((empty( $footer_link)) && (empty($footer_designedbylink_URL))){ ?>
<span>
<?php echo(__($footer_designedby_link,'BlockTradesAffiliatesV1')); ?>
</span>
<?php }else { ?>
<a href="<?php echo $footer_designedbylink_URL;   ?>">
<?php echo(__($footer_designedby_link,'BlockTradesAffiliatesV1')); ?> 
</a>
<?php } ?>
<span id="stt_footer_designed_by">
<?php  $footer_designedby_text = steemtemplates_theme_option('ttr_deisgnedby_text'); 
echo(__($footer_designedby_text,'BlockTradesAffiliatesV1'));
?>
</span>
</div>
</div>
</div>
</footer>
<?php endif; ?>
<div class="remove_collapsing_margins"></div>
<div class="footer-widget-area" role="complementary">
<div class="footer-widget-area_inner">
<?php
if( is_active_sidebar( 'footerbelowcolumn1'  ) || is_active_sidebar( 'footerbelowcolumn2'  ) || is_active_sidebar( 'footerbelowcolumn3'  ) || is_active_sidebar( 'footerbelowcolumn4'  )):
?>
<div class="stt_footer-widget-area_inner_below_widget_container">
<div class="stt_footer-widget-area_inner_below0">
<?php if ( is_active_sidebar('footerbelowcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'FBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('footerbelowcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'FBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('footerbelowcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'FBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('footerbelowcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="footerbelowcolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'FBWidgetArea03'); ?>
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
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>