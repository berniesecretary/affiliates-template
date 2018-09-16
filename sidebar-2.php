<div id="stt_sidebar_right_margin"> 
<div class="remove_collapsing_margins"></div>
<div class="stt_sidebar_right_padding"> 
<div class="remove_collapsing_margins"></div>
<?php if(!steemtemplates_theme_dynamic_sidebar(2)){
global $steemtemplates_theme_widget_args;
extract($steemtemplates_theme_widget_args);
echo ($before_widget.$before_title.__('Category','BlockTradesAffiliatesV1').$after_title); ?>
<ul>
<?php wp_list_categories(); ?>
</ul>
<?php echo substr($after_widget,0,-3); ?>
<?php echo ($before_widget.$before_title.__('Archive','BlockTradesAffiliatesV1').$after_title); ?>
<ul>
<?php wp_get_archives(); ?>
</ul>
<?php echo substr($after_widget,0,-3);
}
?>
<div class="remove_collapsing_margins"></div>
</div>
</div>
