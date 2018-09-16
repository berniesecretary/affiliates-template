/**
* CustomScripts.js 1.0.0
* @author steemtemplates
**/
jQuery(document).ready(function () {
 
/* Button Style Script */
jQuery("#wp-submit").addClass("btn btn-default");
jQuery(".contact_file").addClass(" btn btn-md btn-default");
jQuery(".wpcf7-submit").addClass("pull-left btn btn-md btn-default");
jQuery(".wpcf7-submit").attr("value", "Send Message");
if(jQuery('.wpcf7-file').length){
jQuery('.wpcf7-file').change(function(){
jQuery("#upload-file").text(this.value);
});
}
 
/* Slideshow Function Call */
if(jQuery('#stt_slideshow_inner').length){
jQuery('#stt_slideshow_inner').TTSlider({
slideShowSpeed:2000, begintime:1000,cssPrefix: 'stt_'
});
}
 
/* Sticky menu script */
if(jQuery('#stt_menu').length){
var menuheight = jQuery('nav.navbar').height();
var menutop = jQuery('#stt_menu').offset().top;
jQuery(document).scroll(function () {
var scrollTop = jQuery(this).scrollTop();
var menuOffset = menutop - menuheight;
if(menuOffset < 0)
{
menuOffset = 0;
}
if (scrollTop > menutop) 
{
jQuery('#stt_menu').addClass('navbar-fixed-top');
}
else if (scrollTop <= menuOffset)
{
jQuery('#stt_menu').removeClass('navbar-fixed-top');
}
});
}
 
/* Checkbox Script */
var inputs = document.getElementsByTagName('input');
for (a = 0; a < inputs.length; a++) {
if (inputs[a].type == "checkbox") {
var id = inputs[a].getAttribute("id");
if (id==null){
id=  "checkbox" +a;
}
inputs[a].setAttribute("id",id);
var container = document.createElement('div');
container.setAttribute("class", "stt_checkbox");
var label = document.createElement('label');
label.setAttribute("for", id);
jQuery(inputs[a]).wrap(container).after(label);
}
}

 
/* RadioButton Script */
var inputs = document.getElementsByTagName('input');
for (a = 0; a < inputs.length; a++) {
if (inputs[a].type == "radio") {
var id = inputs[a].getAttribute("id");
if (id==null){
id=  "radio" +a;
}
inputs[a].setAttribute("id",id);
var container = document.createElement('div');
container.setAttribute("class", "stt_radio");
var label = document.createElement('label');
label.setAttribute("for", id);
jQuery(inputs[a]).wrap(container).after(label);
}
}
 
/* -----HamburgerScript ----*/
jQuery('#nav-expander').on('click',function(e){
e.preventDefault();
jQuery('body').toggleClass('nav-expanded');
});
 
/* -----MenuOpenClickScript ----*/
jQuery('ul.stt_menu_items.nav li [data-toggle=dropdown]').on('click', function() {
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
if(window_width > 1025 && jQuery(this).attr('href')){
window.location.href = jQuery(this).attr('href'); 
}
else{
if(jQuery(this).parent().hasClass('open')){
location.assign(jQuery(this).attr('href'));
}
}
});
 
/* -----SidebarMenuOpenClickScript ----*/
jQuery('ul.stt_vmenu_items.nav li [data-toggle=dropdown]').on('click', function() {
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
if(window_width > 1025 && jQuery(this).attr('href')){
window.location.href = jQuery(this).attr('href'); 
}
else{
if(jQuery(this).parent().hasClass('open')){
location.assign(jQuery(this).attr('href'));
}
}
});
 
/*----- PageAlignment Script ------*/
var page_width = jQuery('#stt_page').width();
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
if(window_width > 1025){
jQuery('.stt_page_align_left').each(function() {
var left_div_width = jQuery(this).width(); 
var page_align_left_value = page_width - left_div_width;
left_div_width = left_div_width + 1;
jQuery(this).css({'left' : '-' + page_align_left_value + 'px', 'width': left_div_width + 'px'});
});
jQuery('.stt_page_align_right').each(function() {
var right_div_width = jQuery(this).width(); 
var page_align_left_value = page_width - right_div_width;
right_div_width = right_div_width + 1;
jQuery(this).css({'right' : '-' + page_align_left_value + 'px', 'width': right_div_width + 'px'});
});
}
 
/* ---- TabClickScript ----*/
jQuery('.stt_menu_items ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) { 
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
if(window_width < 1025){
event.preventDefault();
event.stopPropagation();
jQuery(this).parent().siblings().removeClass('open');
jQuery(this).parent().toggleClass(function() {
if (jQuery(this).is(".open") ) {
window.location.href = jQuery(this).children("[data-toggle=dropdown]").attr('href'); 
return "";
} else {
return "open";
}
});
}
});
 
/* ----- TabVMenuClickScript -----*/
jQuery('.stt_vmenu_items ul [data-toggle=dropdown]').on('click', function(event) { 
var window_width =  Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
if(window_width < 1025){
event.preventDefault();
event.stopPropagation();
jQuery(this).parent().siblings().removeClass('open');
jQuery(this).parent().toggleClass(function() {
if (jQuery(this).is(".open") ) {
window.location.href = jQuery(this).children("[data-toggle=dropdown]").attr('href'); 
return "";
} else {
return "open";
}
});
}
});
 
/* ----- GoogleWebFontScript -----*/
 
/*************** Html video script ***************/
var objects = ['iframe[src*="youtube.com"]','iframe[src*="youtu.be"]', 'video','object'];
for(var i = 0 ; i < objects.length ; i++){
if (jQuery(objects[i]).length > 0 && ( jQuery(objects[i]).parents('header').length == 0 )) {
$( "video" ).not( document.getElementById( "#stt_body_video" ) ) . 
jQuery(objects[i]).wrap( "<div class='embed-responsive embed-responsive-16by9'></div>" );
jQuery(objects[i]).addClass('embed-responsive-item');
}
}
});

