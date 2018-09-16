<?php
global $wp_scripts;
global $steemtemplates_justify;
global $steemtemplates_magmenu;
global $steemtemplates_menuh;
global $steemtemplates_vmenuh;
global $steemtemplates_ocmenu;
global $steemtemplates_no_slides, $steemtemplates_slide_show_visible;
$steemtemplates_no_slides = 3;
 $steemtemplates_slide_show_visible = false;
$steemtemplates_magmenu = false;
$steemtemplates_menuh = false;
$steemtemplates_justify = false;
global $steemtemplates_cssprefix;
$steemtemplates_cssprefix="stt_";
global $steemtemplates_fontSize1, $steemtemplates_style1, $sidebarmenuheading;
$steemtemplates_style1="";
$sidebarmenuheading = steemtemplates_theme_option('ttr_sidebarmenuheading');
$steemtemplates_fontSize1 = steemtemplates_theme_option('ttr_font_size_sidebarmenu');
add_shortcode( 'widget', 'my_widget_shortcode' );
function my_widget_shortcode( $atts ) {
global $steemtemplates_cssprefix;
extract( shortcode_atts(
array(
'type'  => '',
'title' => '',
'style' => '',
),
$atts));
if($steemtemplates_style=='block'):
$args = array(
'before_widget' => '<div class="'.$steemtemplates_cssprefix.'block %2$s"><div class="remove_collapsing_margins"></div>',
'after_widget'  => '</div>',
'before_title'  => '<div class="'.$steemtemplates_cssprefix.'block_header"><h3 class="'.$steemtemplates_cssprefix.'block_heading widget_before_title">',
'after_title'   => '</h3></div>',
);
else:
$args = array(
'before_widget' => '<div class="box widget">',
'after_widget'  => '</div>',
'before_title'  => '<div class="wcidget-title">',
'after_title'   => '</div>',
);
endif;
the_widget( $type, $atts, $args );
}
add_action('wp_enqueue_scripts', 'steemtemplates_scripts_method');
function steemtemplates_scripts_method() {
$steemtemplates_js_enable =  steemtemplates_theme_option('ttr_theme_bootstrap_enable');
if($steemtemplates_js_enable)
{
wp_register_script('bootstrapfront', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.2.0', true);
wp_enqueue_script('bootstrapfront');
}
wp_register_script('customscripts', get_template_directory_uri() . '/js/customscripts.js', array('jquery'), '1.0.0', true);
 wp_enqueue_script('customscripts');
wp_register_script('totop', get_template_directory_uri() . '/js/totop.js', array('jquery'), '1.0.0', true);
wp_enqueue_script('totop');
wp_register_script('tt_googlemaps', '//maps.googleapis.com/maps/api/js',  '1.0.0', true);
wp_enqueue_style('menuie', get_stylesheet_directory_uri() . '/menuie.css');
wp_style_add_data('menuie', 'conditional', 'if lte IE 8');
wp_enqueue_style('vmenuie', get_stylesheet_directory_uri() . '/vmenuie.css');
wp_style_add_data('vmenuie', 'conditional', 'if lte IE 8');
wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css');
wp_enqueue_style('bootstrap');
wp_register_style('rtl', get_stylesheet_directory_uri() . '/rtl.css');
wp_register_style('style', get_stylesheet_directory_uri() . '/style.css');
wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');
}
function steemtemplates_widgets_init() {
global $steemtemplates_cssprefix;
$steemtemplates_cssprefix="stt_";
global $steemtemplates_theme_widget_args;
global $steemtemplates_fontSize, $steemtemplates_style;
$heading_tag = steemtemplates_theme_option('ttr_heading_tag_block');
 if(empty($heading_tag) || $heading_tag == Null){
$heading_tag = 'h3';
}
$steemtemplates_style="";
 $blockheading = steemtemplates_theme_option('ttr_blockheading');
 $steemtemplates_fontSize = steemtemplates_theme_option('ttr_font_size_block');
 if(!empty($blockheading)){
 $steemtemplates_style .= "color:".$blockheading.";";
 }
 if(!empty($steemtemplates_fontSize)){
 $steemtemplates_style .= "font-size:".$steemtemplates_fontSize."px;";
 }
$steemtemplates_theme_widget_args = array('before_widget' => '<div class="'.$steemtemplates_cssprefix.'block %2$s"><div class="remove_collapsing_margins"></div> <div class="'.$steemtemplates_cssprefix.'block_header">',
'after_widget' => '</div></div>~tt',
'before_title' => '<'.steemtemplates_theme_option('ttr_heading_tag_block').' class="'.$steemtemplates_cssprefix.'block_heading">
',
'after_title' => '</'.$heading_tag.'></div> <div id="%1$s" class="'.$steemtemplates_cssprefix.'block_content">',
);
extract($steemtemplates_theme_widget_args);
register_sidebar( array(
'name' => __( 'CAWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'contenttopcolumn1',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CAWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'contenttopcolumn2',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CAWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'contenttopcolumn3',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CAWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'contenttopcolumn4',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'headerabovecolumn1',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'headerabovecolumn2',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'headerabovecolumn3',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HAWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'headerabovecolumn4',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'headerbelowcolumn1',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'headerbelowcolumn2',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'headerbelowcolumn3',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'HBWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'headerbelowcolumn4',
'description' => __( 'An optional widget area for your site header', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'menuabovecolumn1',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'menuabovecolumn2',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'menuabovecolumn3',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MAWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'menuabovecolumn4',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'menubelowcolumn1',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'menubelowcolumn2',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'menubelowcolumn3',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'MBWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'menubelowcolumn4',
'description' => __( 'An optional widget area for your site menu', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'contentbottomcolumn1',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'contentbottomcolumn2',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'contentbottomcolumn3',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'CBWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'contentbottomcolumn4',
'description' => __( 'An optional widget area for your site content', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'footerabovecolumn1',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'footerabovecolumn2',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'footerabovecolumn3',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FAWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'footerabovecolumn4',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea00', 'BlockTradesAffiliatesV1' ),
'id' => 'footerbelowcolumn1',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea01', 'BlockTradesAffiliatesV1' ),
'id' => 'footerbelowcolumn2',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea02', 'BlockTradesAffiliatesV1' ),
'id' => 'footerbelowcolumn3',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'FBWidgetArea03', 'BlockTradesAffiliatesV1' ),
'id' => 'footerbelowcolumn4',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'first-footer-widget-area', 'BlockTradesAffiliatesV1' ),
'id' => 'first-footer-widget-area',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'second-footer-widget-area', 'BlockTradesAffiliatesV1' ),
'id' => 'second-footer-widget-area',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => __( 'third-footer-widget-area', 'BlockTradesAffiliatesV1' ),
'id' => 'third-footer-widget-area',
'description' => __( 'An optional widget area for your site footer', 'BlockTradesAffiliatesV1' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => "</aside>~tt",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'widgets_init', 'steemtemplates_widgets_init' );?>
