<?php
/**
* Template Name:search
* @package steemtemplates
*/
get_header(); ?>
<div id="stt_content_and_sidebar_container">
<div id="stt_content">
<div id="stt_content_margin">
<div class="remove_collapsing_margins"></div>
<?php if (steemtemplates_theme_option("ttr_post_breadcrumb")):?>
<?php steemtemplates_wordpress_breadcrumbs(); ?>
<?php endif; ?>
<?php
if( is_active_sidebar( 'contenttopcolumn1'  ) || is_active_sidebar( 'contenttopcolumn2'  ) || is_active_sidebar( 'contenttopcolumn3'  ) || is_active_sidebar( 'contenttopcolumn4'  )):
?>
<div class="stt_topcolumn_widget_container">
<div class="contenttopcolumn0">
<?php if ( is_active_sidebar('contenttopcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'CAWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('contenttopcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'CAWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('contenttopcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'CAWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('contenttopcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="topcolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'CAWidgetArea03'); ?>
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
<?php  /*query_posts($query_string. '&showposts='.steemtemplates_theme_option('ttr_query_result')); */query_posts($query_string . '&posts_per_page&orderby=modified&order=desc');?>
<?php if ( have_posts() ) : ?>
<h1>
<?php printf( __( 'Search Results for: %s', 'BlockTradesAffiliatesV1' ), '<span>' . get_search_query() . '</span>' ); ?>
</h1>
<?php steemtemplates_content_nav( 'nav-above' ); ?>
<?php
$layoutoption=4;
$featuredpost=1;
$themelayoutoption = steemtemplates_theme_option('ttr_post_layout');
$themefeaturedpost = steemtemplates_theme_option('ttr_featured_post');
if(isset($themelayoutoption))
$layoutoption = steemtemplates_theme_option('ttr_post_layout');
if(isset($themefeaturedpost))
$featuredpost = steemtemplates_theme_option('ttr_featured_post');
?>
<?php
if($layoutoption==1)
{
while ( have_posts())
{
the_post();
get_template_part( 'content',get_post_format());
}
}
else
{
$columncount=0;
$lastpost=true;
$flag=true;
while( have_posts())
{
$lastpost=true;
if($featuredpost > 0)
{
echo '<div class="row">';
echo '<div class="col-lg-12 list">';
the_post();
get_template_part( 'content',get_post_format());
echo '</div></div>';
$featuredpost--;
$lastpost=false;
}
else
{
if($flag){
echo '<div class=" row">';
$flag=false;}
$class_suffix_lg  = round((12/$layoutoption));
if(empty($class_suffix_lg)){ 
$class_suffix_lg  =4;
}
 $md =4;
$class_suffix_md  = round((12 / $md));
 $xs =1;
$class_suffix_xs  = round((12 / $xs));
if (is_search() ) { 
echo '<div class="grid col-lg-12 col-md-12 col-sm-12 col-xs-12">';
 } else { 
echo '<div class="grid col-lg-'.$class_suffix_lg.' col-md-'.$class_suffix_md.' col-sm-'.$class_suffix_md.' col-xs-'.$class_suffix_xs.'">';
 } 
the_post();
get_template_part( 'content',get_post_format());
echo '</div>';
$columncount++;
if($columncount % $xs == 0 && $columncount != 0){ echo '<div class="visible-xs-block" style="clear:both;"></div>';}
if($columncount % $md == 0 && $columncount != 0){ echo '<div class="visible-sm-block" style="clear:both;"></div>';
echo '<div class=" visible-md-block" style="clear:both;"></div>';}
if($columncount % $layoutoption == 0 && $columncount != 0){ echo '<div class=" visible-lg-block" style="clear:both;"></div>';}
$lastpost=true;
}
}
if (!$flag){
echo '</div>';
}
}
?>
<div style="clear: both;">
<?php steemtemplates_content_nav( 'nav-below' ); ?>
</div>
<?php else : ?>
<h2 class="stt_post_title entry-title">
<?php _e( 'Nothing Found', 'BlockTradesAffiliatesV1' ); ?></h2>
<div class="postcontent entry-content">
<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'BlockTradesAffiliatesV1' ); ?></p>
<?php get_search_form(); ?>
<div style="clear: both;"></div>
</div>
<?php endif; ?>
<?php
if( is_active_sidebar( 'contentbottomcolumn1'  ) || is_active_sidebar( 'contentbottomcolumn2'  ) || is_active_sidebar( 'contentbottomcolumn3'  ) || is_active_sidebar( 'contentbottomcolumn4'  )):
?>
<div class="stt_bottomcolumn_widget_container">
<div class="contentbottomcolumn0">
<?php if ( is_active_sidebar('contentbottomcolumn1') ) : ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn1">
<?php steemtemplates_theme_dynamic_sidebar( 'CBWidgetArea00'); ?>
</div>
</div>
<?php else: ?>
<div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('contentbottomcolumn2') ) : ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn2">
<?php steemtemplates_theme_dynamic_sidebar( 'CBWidgetArea01'); ?>
</div>
</div>
<?php else: ?>
<div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-sm-block visible-md-block visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('contentbottomcolumn3') ) : ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn3">
<?php steemtemplates_theme_dynamic_sidebar( 'CBWidgetArea02'); ?>
</div>
</div>
<?php else: ?>
<div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12transparent">
&nbsp;
</div>
<?php endif; ?>
<div class=" visible-xs-block" style="clear:both;"></div>
<?php if ( is_active_sidebar('contentbottomcolumn4') ) : ?>
<div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
<div class="bottomcolumn4">
<?php steemtemplates_theme_dynamic_sidebar( 'CBWidgetArea03'); ?>
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
<div class="remove_collapsing_margins"></div>
</div>
</div>
<div style="clear: both;"></div>
</div>
<?php get_footer(); ?>