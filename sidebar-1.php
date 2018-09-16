<div id="stt_sidebar_left_margin"> 
<div class="remove_collapsing_margins"></div>
<div class="stt_sidebar_left_padding">
<div class="remove_collapsing_margins"></div>
<?php if(!steemtemplates_theme_dynamic_sidebar(1)){
global $steemtemplates_theme_widget_args;
extract($steemtemplates_theme_widget_args);
echo ($before_widget.$before_title.__('Search','BlockTradesAffiliatesV1').$after_title);
get_search_form();
echo substr($after_widget,0,-3);
echo ($before_widget.$before_title.__('Calendar','BlockTradesAffiliatesV1').$after_title);
get_calendar();
echo substr($after_widget,0,-3);
}
?>
<div class="remove_collapsing_margins"></div>
 </div> 
</div>
